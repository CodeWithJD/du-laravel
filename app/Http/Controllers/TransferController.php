<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Mail\OtpMail;


class TransferController extends Controller
{
    public function transfer()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Retrieve user's balance
        $userDetails = UserDetails::where('user_id', $user->id)->first();

        return view('dashboard.transferotp', [
            'name' => $user->name,
            'balance' => $userDetails->available_balance, // Pass available balance
        ]);
    }

    public function sendOtp(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Check if there is an unused OTP for the user
        $existingOtp = DB::table('otp_codes')
            ->where('user_id', $user->id)
            ->where('status', 'unused')
            ->where('expires_at', '>', now())
            ->first();

        if ($existingOtp) {
            return response()->json(['message' => 'An unused OTP already exists. Please wait 10 minutes for it to expire or use it before requesting a new one.'], 400);
        }

        // OTP generation logic
        $otp = rand(100000, 999999);

        // Save OTP to database
        DB::table('otp_codes')->insert([
            'user_id' => $user->id,
            'otp_code' => $otp,
            'created_at' => now(),
            'expires_at' => now()->addMinutes(10), // OTP expires in 10 minutes
            'status' => 'unused' // OTP status
        ]);

        // Send OTP to logged-in user's email
        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'OTP sent successfully']);
    }


    public function validateTransfer(Request $request)
    {
        // Temporary disable function
        if (false) {
            return back()->withErrors(['email' => 'Function temporarily disabled.'])->withInput();
        }

        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Validate transfer details
        $validatedData = $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
            'otp' => 'required|numeric',
        ]);

        // Check OTP
        $otpRecord = DB::table('otp_codes')
        ->where('user_id', $user->id)
        ->where('otp_code', $validatedData['otp'])
        ->where('expires_at', '>', now())
        ->where('status', 'unused')
        ->first();

        if (!$otpRecord) {
        return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
        }

        // Check recipient existence
        $recipient = User::where('email', $validatedData['email'])->first();
        if (!$recipient) {
            return back()->withErrors(['email' => 'Invalid email.'])->withInput();
        }

        // Retrieve user's balance
        $userDetails = UserDetails::where('user_id', $user->id)->first();
        if ($userDetails->available_balance < $validatedData['amount']) {
            return back()->withErrors(['amount' => 'Insufficient balance.'])->withInput();
        }

        // Fetch transfer fee from reward_settings
        $transferCharge = DB::table('reward_settings')->value('transfer_charge');
        $totalAmount = $validatedData['amount'] + $transferCharge; // Total amount including fee

        // Check if user has sufficient balance including fee
        if ($userDetails->available_balance < $totalAmount) {
            return back()->withErrors(['amount' => 'Insufficient balance including transfer fee.'])->withInput();
        }

        // Show transfer page again with recipient details
        return view('dashboard.transferotp', [
            'name' => $user->name,
            'balance' => $userDetails->available_balance,
            'recipient' => $recipient,
            'amount' => $validatedData['amount'],
            'transferCharge' => $transferCharge, // Pass transfer fee
            'totalAmount' => $totalAmount, // Pass total amount
            'otp' => $validatedData['otp'], // Pass total amount
        ]);
    }

    public function completeTransfer(Request $request)
    {

        // Temporary disable function
        if (false) {
            return back()->withErrors(['email' => 'Function temporarily disabled.'])->withInput();
        }

        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        $validatedData = $request->validate([
            'recipient_id' => 'required|integer',
            'amount' => 'required|numeric|min:1',
            'otp' => 'required|numeric',
        ]);

        $recipient = User::find($validatedData['recipient_id']);
        if (!$recipient) {
            return back()->withErrors(['recipient_id' => 'Recipient not found.']);
        }

        $userDetails = UserDetails::where('user_id', $user->id)->first();
        $transferCharge = DB::table('reward_settings')->value('transfer_charge');
        $totalAmount = $validatedData['amount'] + $transferCharge; // Total amount including fee

        if ($userDetails->available_balance < $totalAmount) {
            return back()->withErrors(['amount' => 'Insufficient balance including transfer fee.']);
        }

        // Check OTP
        $otpRecord = DB::table('otp_codes')
        ->where('user_id', $user->id)
        ->where('otp_code', $validatedData['otp'])
        ->where('expires_at', '>', now())
        ->where('status', 'unused')
        ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Generate unique transaction hash
        do {
            $transactionHash = '0xDu' . mt_rand(1000000000, 9999999999);
        } while (Transaction::where('transaction_hash', $transactionHash)->exists());

        DB::transaction(function () use ($user, $userDetails, $recipient, $validatedData, $transferCharge, $totalAmount, $transactionHash, $otpRecord) {
            // Deduct total amount including fee from sender
            $userDetails->available_balance -= $totalAmount;
            $userDetails->save();

            // Add amount to recipient
            $recipientDetails = UserDetails::where('user_id', $recipient->id)->first();
            $recipientDetails->available_balance += $validatedData['amount'];
            $recipientDetails->save();

            // Record the transaction
            Transaction::create([
                'transaction_source' => 'Du Wallet',
                'user_id' => $user->id, // Directly use `user` object's ID
                'recipient_id' => $recipient->id,
                'amount' => $validatedData['amount'],
                'status' => 'Complete',
                'transaction_hash' => $transactionHash,
                'description' => "{$user->name} transferred {$validatedData['amount']} DU to {$recipient->name}. Transaction ID: {$transactionHash}",
                'transfer_charge' => $transferCharge, // Record transfer fee
            ]);

            // Mark OTP as used
            DB::table('otp_codes')
            ->where('id', $otpRecord->id)
            ->update(['status' => 'used']);
            });

        return redirect()->route('wallet.index')->with('success', 'Transfer successful.');
    }
}
