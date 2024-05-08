<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UserDetails;
use App\Models\Transaction;


class SwapController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');  // Ensure the user is logged in
        }

        // Retrieve user details, assuming the available balance is stored there
        $userDetails = UserDetails::where('user_id', $user->id)->firstOrFail();

        return view('dashboard.swap', [
            'name' => $user->name,
            'available_balance' => $userDetails->available_balance // Pass available balance
        ]);
    }

    // Swap confirm funcation
    public function processSwap(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('login');
        }

        // Validate the inputs
        $validatedData = $request->validate([
            'currency' => 'required|string|in:usdt,du',
            'amount' => 'required|numeric|min:1'
        ]);

        $currency = $validatedData['currency'];
        $amount = $validatedData['amount'];

        // Initialize variables for clarity
        $exchangeAmount = 0;
        $exchangeRateKey = $currency === 'usdt' ? 'exchange_rate_usdt' : 'exchange_rate_du';

        // Fetch the appropriate exchange rate from global_settings
        $exchangeRate = DB::table('global_settings')->value($exchangeRateKey);

        if (!$exchangeRate) {
            return back()->withErrors(['error' => "Exchange rate not found for {$currency}."]);
        }

        // Calculate the converted amount
        $exchangeAmount = $amount / $exchangeRate;

        // Prepare data to pass to the view
        return view('dashboard.swap-process', [
            'name' => $user->name,
            'currency' => $currency,
            'swapAmount' => $amount,
            'exchangeAmount' => $exchangeAmount,
            'exchangeRate' => $exchangeRate
        ]);
    }

    public function processConfirm(Request $request){
        $user = Auth::user();
        if (!$user) {
            return redirect('login');
        }

        // Validate the inputs
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:usdt,du',
            'wallet' => 'required|string',
            'transaction_id' => 'required|string',
        ]);

        $currency = $validatedData['currency'];
        $amount = $validatedData['amount'];
        $wallet = $validatedData['wallet'];
        $transaction_id = $validatedData['transaction_id'];

        // Initialize variables for clarity
        $exchangeRateKey = $currency === 'usdt' ? 'exchange_rate_usdt' : 'exchange_rate_du';

        // Fetch the appropriate exchange rate from global_settings
        $exchangeRate = DB::table('global_settings')->value($exchangeRateKey);

        if (!$exchangeRate) {
            return back()->withErrors(['error' => "Exchange rate not found for {$currency}."]);
        }

        $exchangeAmount = $amount / $exchangeRate;
        $transferCharge = 0; // Define how the transfer charge is determined

        // Generate unique transaction hash
        do {
            $transactionHash = '0xDu' . mt_rand(1000000000, 9999999999);
        } while (Transaction::where('transaction_hash', $transactionHash)->exists());

        // Record the transaction
        Transaction::create([
            'transaction_source' => "{$currency} Wallet",
            'recipient_id' => $user->id,
            'amount' => $exchangeAmount,
            'status' => 'in Progress',
            'transaction_hash' => $transactionHash,
            'sender_address' => $wallet,
            'blockchain_hash' => $transaction_id,
            'description' => "{$user->name} Swap {$amount} {$currency} equivalent to {$exchangeAmount} DU.",
        ]);

        return redirect()->route('wallet.index')->with([
            'message' => "Transaction successfully initiated for {$amount} {$currency} equivalent to {$exchangeAmount} DU."
        ]);
    }



}
