<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserDetails;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlockchainTransferController extends Controller
{
    public function withdraw()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Retrieve user's balance
        $userDetails = UserDetails::where('user_id', $user->id)->first();
        $limitWithdrawMax = DB::table('reward_settings')->value('limit_withdraw_max');


        return view('dashboard.withdraw', [
            'name' => $user->name,
            'balance' => $userDetails->available_balance, // Pass available balance
            'limit' => $userDetails->daily_withdrawal_limit,
            'wallet_address' => $userDetails->withdrawal_wallet,
            'limitWithdrawMax' => $limitWithdrawMax,

        ]);
    }

    public function validateWithdraw(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Validate transfer details
        $validatedData = $request->validate([
            'walletaddress' => ['required', 'regex:/^0x[a-fA-F0-9]{40}$/'], // Wallet address starts with 0x followed by 40 hexadecimal characters
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

        // Retrieve user's balance
        $userDetails = UserDetails::where('user_id', $user->id)->first();
        if ($userDetails->available_balance < $validatedData['amount']) {
            return back()->withErrors(['amount' => 'Insufficient balance.'])->withInput();
        }

        // Fetch transfer fee and maximum limit from reward_settings
        $withdrawCharge = DB::table('reward_settings')->value('withdrawal_charge');
        $limitWithdrawMax = DB::table('reward_settings')->value('limit_withdraw_max');
        $totalAmount = $validatedData['amount'] + $withdrawCharge; // Total amount including fee

        // Check if amount exceeds the max limit
        if ($validatedData['amount'] > $limitWithdrawMax) {
            return back()->withErrors(['amount' => 'You cannot withdraw more than 50 DU Coins per day.'])->withInput();
        }

        // Check if user has sufficient balance including fee
        if ($userDetails->available_balance < $totalAmount) {
            return back()->withErrors(['amount' => 'Insufficient balance including withdraw fee.'])->withInput();
        }

        // Check daily withdrawal limit
        $dailyWithdrawalLimit = $userDetails->daily_withdrawal_limit;

        // Calculate the remaining limit for the day
        $remainingLimit = $limitWithdrawMax - $dailyWithdrawalLimit;

        if ($validatedData['amount'] > $remainingLimit) {
            return back()->withErrors(['amount' => 'Daily withdrawal limit exceeded.'])->withInput();
        }

        $limitWithdrawMax = DB::table('reward_settings')->value('limit_withdraw_max');


        // Show transfer page again with recipient details
        return view('dashboard.withdraw', [
            'name' => $user->name,
            'balance' => $userDetails->available_balance,
            'recipient_address' => $validatedData['walletaddress'],
            'amount' => $validatedData['amount'],
            'withdrawCharge' => $withdrawCharge, // Pass transfer fee
            'totalAmount' => $totalAmount, // Pass total amount
            'otp' => $validatedData['otp'], // Pass total amount
            'limit' => $userDetails->daily_withdrawal_limit,
            'limitWithdrawMax' => $limitWithdrawMax,

        ]);
    }

    public function completewithdraw(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        $validatedData = $request->validate([
            'walletaddress' => ['required', 'regex:/^0x[a-fA-F0-9]{40}$/'], // Wallet address starts with 0x followed by 40 hexadecimal characters
            'amount' => 'required|numeric|min:1',
            'otp' => 'required|numeric',
        ]);

        $userDetails = UserDetails::where('user_id', $user->id)->first();

        $withdrawCharge = DB::table('reward_settings')->value('withdrawal_charge');
        $limitWithdrawMax = DB::table('reward_settings')->value('limit_withdraw_max');
        $totalAmount = $validatedData['amount'] + $withdrawCharge; // Total amount including fee

        // Check if the amount exceeds the max limit
        if ($validatedData['amount'] > $limitWithdrawMax) {
            return back()->withErrors(['amount' => 'You cannot withdraw more than the maximum allowed limit in one transaction.']);
        }

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

        // Check daily withdrawal limit
        $dailyWithdrawalLimit = $userDetails->daily_withdrawal_limit;

        // Calculate the remaining limit for the day
        $remainingLimit = $limitWithdrawMax - $dailyWithdrawalLimit;

        if ($validatedData['amount'] > $remainingLimit) {
            return back()->withErrors(['amount' => 'Daily withdrawal limit exceeded.']);
        }

        try {
            DB::beginTransaction();

            // Deduct total amount including fee from user balance
            $userDetails->available_balance -= $totalAmount;
            $userDetails->daily_withdrawal_limit += $validatedData['amount']; // Update daily withdrawal limit
            $userDetails->save();

            // Record the transaction
            $transaction = Transaction::create([
                'transaction_source' => 'Metamask',
                'user_id' => $user->id,
                'recipient_id' => null,
                'sender_address' => null,
                'recipient_address' => $validatedData['walletaddress'],
                'amount' => $validatedData['amount'],
                'status' => 'in Progress',
                'transaction_hash' => null, // Will be updated after blockchain transaction
                'description' => "{$user->name} withdrew {$validatedData['amount']} DU to blockchain wallet.",
                'transfer_charge' => $withdrawCharge, // Record transfer fee
            ]);

            // Mark OTP as used
            DB::table('otp_codes')
                ->where('id', $otpRecord->id)
                ->update(['status' => 'used']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error
            Log::error('Transaction failed: ' . $e->getMessage());

            // Return with error message
            return back()->withErrors(['transaction' => 'Transaction failed. Please try again later.']);
        }

        return redirect()->route('wallet.index')->with('success', 'Withdrawal request completed successfully.');
    }

}
