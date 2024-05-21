<?php

namespace App\Http\Controllers;

use App\Models\FeesCounter;
use App\Models\RewardSetting;
use App\Models\Transaction;
use App\Models\UserDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Retrieve wallet details from the user_details table
        $userDetails = UserDetails::where('user_id', $user->id)->first();

        // Retrieve transactions involving the user
        $transactionsQuery = Transaction::where('user_id', $user->id)
            ->orWhere('recipient_id', $user->id)
            ->orderBy('created_at', 'desc'); // Order by recent transactions using created_at

        // Paginate the transactions
        $perPage = 6;
        $transactions = $transactionsQuery->paginate($perPage);

        $todayTransfers = $userDetails->daily_reward_transfer_used;

        $rewardSettings = RewardSetting::first();
        $dailyTransferLimit = $rewardSettings->daily_reward_transfer_limit;



        return view('dashboard.wallet', [
            'user' => $user,
            'name' => $user->name,
            'userDetails' => $userDetails,
            'transactions' => $transactions,
            'todayTransfers' => $todayTransfers,
            'dailyTransferLimit' => $dailyTransferLimit
        ]);
    }

    public function transferRewardToAvailable(Request $request)
    {
        $user = Auth::user();
        $userDetails = $user->userDetails;

        if ($userDetails->reward_balance <= 0) {
            return back()->withErrors(['error' => 'No reward balance available to transfer.']);
        }

        $request->validate([
            'transfer_amount' => 'required|numeric|min:1',
        ]);

        $transferAmount = $request->input('transfer_amount');

        // Check if user has enough reward balance
        if ($userDetails->reward_balance < $transferAmount) {
            return back()->withErrors(['error' => 'Not enough reward balance available to transfer.']);
        }

        $rewardSettings = RewardSetting::first();
        $transferFeePercentage = $rewardSettings->reward_to_balance_transfer_fees;
        $dailyTransferLimit = $rewardSettings->daily_reward_transfer_limit;

        $todayTransfers = $userDetails->daily_reward_transfer_used;

        if ($todayTransfers + $transferAmount > $dailyTransferLimit) {
            return back()->withErrors(['error' => 'Daily transfer limit exceeded.']);
        }

        // Calculate the transfer amount after deducting the fee
        $transferCharge = $transferAmount * $transferFeePercentage / 100;
        $amountAfterFee = $transferAmount - $transferCharge;

        if ($amountAfterFee < 1) {
            return back()->withErrors(['error' => 'Minimum transfer amount after fee is 1 DU.']);
        }

        // Update user balances
        $userDetails->available_balance += $amountAfterFee;
        $userDetails->reward_balance -= $transferAmount;
        $userDetails->daily_reward_transfer_used += $transferAmount;
        $userDetails->save();

        // Generate unique transaction hash
        do {
            $transactionHash = '0xDu' . mt_rand(1000000000, 9999999999);
        } while (Transaction::where('transaction_hash', $transactionHash)->exists());

        // Record the transaction
        Transaction::create([
            'transaction_source' => 'Rewards',
            'user_id' => null,
            'recipient_id' => $user->id,
            'amount' => $amountAfterFee,
            'status' => 'Complete',
            'transaction_hash' => $transactionHash,
            'description' => "{$user->name} withdrawal reward {$transferAmount} DU and Gas Fee: {$transferCharge} and {$amountAfterFee} credit to your account. Transaction ID: {$transactionHash}",
            'transfer_charge' => $transferCharge,
        ]);

        // Insert fee details into fees_counter table
        DB::table('fees_counter')->insert([
            'fee_type' => 'Reward Withdrawal',
            'total_fee' => $transferCharge,
            'transaction_hash' => $transactionHash,
        ]);

        return back()->with('message', 'Reward balance transferred to available balance successfully.');
    }

}
