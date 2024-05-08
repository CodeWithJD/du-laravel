<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Staking;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use App\Models\Transaction;


class InvestmentsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Retrieve wallet details and reward settings
        $userDetails = UserDetails::where('user_id', $user->id)->first();
        $rewardSettings = DB::table('reward_settings')
            ->select('unstaking_gas_fee', 'staking_400d_reward', 'staking_200d_reward')
            ->first();

        // Fetch all staking records
        $stakings = Staking::where('user_id', $user->id)->get();
        $activeStakings = $stakings->filter(fn($staking) => !$staking->unstake);

        // Prepare options
        $stakingOptions = $activeStakings->map(function ($staking) {
            return [
                'id' => $staking->staking_id,
                'amount' => floatval($staking->investedAmount), // Ensure conversion
                'timeframe' => intval($staking->timeframe),
                'reward_paid' => floatval($staking->reward_paid), // Ensure conversion
            ];
        });

        return view('dashboard.investments', [
            'name' => $user->name,
            'available_balance' => $userDetails->available_balance,
            'rewardSettings' => $rewardSettings,
            'stakingOptions' => $stakingOptions,
        ]);
    }

    public function processUnstake(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Check if unstake is allowed based on global settings
        $unstakeAllowed = DB::table('global_settings')
                            ->value('unstake');

        if ($unstakeAllowed == 0) {
        return back()->withErrors(['error' => 'Unstaking is not allowed at this time due to maintenance.']);
        }

        $rewardSettings = DB::table('reward_settings')
            ->select('unstaking_gas_fee', 'staking_400d_reward', 'staking_200d_reward')
            ->first();

        $staking = Staking::where('staking_id', $request->staking_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$staking) {
            return back()->withErrors(['error' => 'Staking not found']);
        }

        // Calculate the total amount and penalty considering the reward_paid amount
        $totalAmount = $staking->investedAmount; // Deducting reward_paid from total amount
        $penalty = $totalAmount * ($rewardSettings->unstaking_gas_fee / 100); // Applying penalty as percentage of remaining amount
        $unstakeAmount = $totalAmount - $penalty - $staking->reward_paid; // Final amount after deducting penalty

        return view('dashboard.unstake-confirm', [
            'name' => $user->name,
            'staking' => $staking,
            'penaltyAmount' => $penalty,
            'totalAmount' => $totalAmount,
            'unstakeAmount' => $unstakeAmount,
        ]);
    }

    public function confirmUnstake(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        $userDetails = UserDetails::where('user_id', $user->id)->first();

        if (!$userDetails) {
            return back()->withErrors(['error' => 'User details not found']);
        }

        $staking = Staking::where('staking_id', $request->staking_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$staking) {
            return back()->withErrors(['error' => 'Staking not found']);
        }

        $rewardSettings = DB::table('reward_settings')
            ->select('unstaking_gas_fee')
            ->first();

        if (!$rewardSettings) {
            return back()->withErrors(['error' => 'Reward settings not found']);
        }

        // Calculate the total amount and penalty considering the reward_paid amount
        $totalAmount = $staking->investedAmount; // Deducting reward_paid from total amount
        $penalty = $totalAmount * ($rewardSettings->unstaking_gas_fee / 100); // Applying penalty as percentage of remaining amount
        $unstakeAmount = $totalAmount - $penalty - $staking->reward_paid; // Final amount after deducting penalty

        DB::table('stakings')
            ->where('staking_id', $staking->staking_id)
            ->update([
                'unstake' => true,
                'updated_at' => now(),
            ]);

        $userDetails->available_balance += $unstakeAmount;
        $userDetails->save();

        $transactionHash = $this->generateTransactionHash();

        Transaction::create([
            'transaction_source' => 'Staking Unstake',
            'user_id' => null,
            'recipient_id' => $userDetails->user_id,
            'amount' => $unstakeAmount,
            'status' => 'Complete',
            'transaction_hash' => $transactionHash,
            'description' => "{$user->name} unstaked {$unstakeAmount} DU from staking. Transaction ID: {$transactionHash}",
        ]);

        DB::table('fees_counter')
        ->insert([
            'fee_type' => 'unstaking_gas_fee',
            'total_fee' => $penalty,
            'transaction_hash' => $transactionHash,
        ]);

        DB::table('fees_counter')
        ->insert([
            'fee_type' => 'reward_return',
            'total_fee' => $staking->reward_paid,
            'transaction_hash' => $transactionHash,
        ]);

        return redirect()->route('investments.index')->with([
            'message' => 'Staking successfully unstaked',
        ]);
    }

    public function processStake(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('login');
        }

        // Validate the inputs
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:10', // Ensure amount is a number and at least 10
            'timeframe' => 'required|in:200,400', // Ensure timeframe is either 200 or 400
        ]);

        $amount = $validatedData['amount'];
        $timeframe = $validatedData['timeframe'];

        $userDetails = UserDetails::where('user_id', $user->id)->first();

        // Fetch reward settings
        $rewardSettings = DB::table('reward_settings')
            ->select('staking_gas_fee', 'staking_200d_reward', 'staking_400d_reward')
            ->first();

        $stakingGasFee = $rewardSettings->staking_gas_fee;

        $totalDeduction = $amount + $stakingGasFee;

        if ($userDetails->available_balance < $totalDeduction) {
            return back()->withErrors(['error' => 'Insufficient balance.']);
        }

        $dailyReward = ($timeframe == 200) ? $rewardSettings->staking_200d_reward : $rewardSettings->staking_400d_reward;

        return view('dashboard.stake-confirm', [
            'name' => $user->name,
            'amount' => $amount,
            'timeframe' => $timeframe,
            'stakingGasFee' => $stakingGasFee,
            'dailyReward' => $dailyReward,
            'totalDeduction' => $totalDeduction,
        ]);
    }

    public function confirmStake(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('login');
        }

        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:10', // Ensure amount is a number and at least 10 DU
            'timeframe' => 'required|in:200,400', // Ensure timeframe is either 200 or 400
        ]);

        $amount = $validatedData['amount'];
        $timeframe = $validatedData['timeframe'];

        $userDetails = UserDetails::where('user_id', $user->id)->first();

        // Fetch reward settings
        $rewardSettings = DB::table('reward_settings')
            ->select('staking_gas_fee', 'staking_200d_reward', 'staking_400d_reward')
            ->first();

        $stakingGasFee = $rewardSettings->staking_gas_fee;
        $totalDeduction = $amount + $stakingGasFee;

        if ($userDetails->available_balance < $totalDeduction) {
            return redirect()->route('investments.index')->withErrors(['error' => 'Insufficient balance.']);
        }

        $dailyReward = ($timeframe == 200) ? $rewardSettings->staking_200d_reward : $rewardSettings->staking_400d_reward;

        // Deduct balance from the user
        $userDetails->available_balance -= $totalDeduction;
        $userDetails->save();

        $depositTime = now();
        $timeframe = (int) $request->input('timeframe'); // Convert timeframe to integer before using
        $withdrawnTime = $depositTime->copy()->addDays($timeframe); // Now this should work without error


        // Create a new staking entry
        Staking::create([
            'user_id' => $user->id,
            'investedAmount' => $amount,
            'DepositTime' => $depositTime,
            'withdrawnTime' => $withdrawnTime,
            'timeframe' => $timeframe,
        ]);

        $transactionHash = $this->generateTransactionHash();

        // Record the transaction
        Transaction::create([
            'transaction_source' => 'Staking Deposit',
            'user_id' => $user->id,
            'recipient_id' => null,
            'amount' => $amount,
            'status' => 'Complete',
            'transaction_hash' => $transactionHash,
            'description' => "{$user->name} staked {$amount} DU for {$timeframe} days.",
        ]);

        // Record the fee counter
        DB::table('fees_counter')->insert([
            'fee_type' => 'staking_gas_fee',
            'total_fee' => $stakingGasFee,
            'transaction_hash' => $transactionHash,
        ]);

        return redirect()->route('investments.index')->with([
            'message' => "Staking successfully created for amount: {$amount} DU for {$timeframe} days.",
        ]);
    }

    private function generateTransactionHash()
    {
        return '0xDu' . strtoupper(Str::random(10));
    }

}
