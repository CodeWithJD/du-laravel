<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Transaction;
use App\Models\FeesCounter;
use App\Models\StakingReward;
use App\Models\ReferralReward;
use Carbon\Carbon;


class AdminUsersController extends Controller
{
    public function userListShow(Request $request) {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('login')->withErrors('Please Login first...!.');
        }

        $adminUser = Auth::guard('admin')->user();

        $search = $request->input('search');
        $status = $request->input('status');

        // Build the query using search and status filters
        $users = User::with('userDetails')
                    ->where(function($query) use ($search) {
                        if (!empty($search)) {
                            $query->where('name', 'like', '%' . $search . '%')
                                  ->orWhere('email', 'like', '%' . $search . '%')
                                  ->orWhere('phone', 'like', '%' . $search . '%')
                                  ->orWhere('id', 'like', '%' . $search . '%')
                                  ->orWhere('invite_code', 'like', '%' . $search . '%');
                        }
                    })
                    ->whereHas('userDetails', function ($query) use ($status) {
                        if (!empty($status) && $status != 'all') {
                            $query->where('account_status', $status);
                        }
                    })
                    ->paginate(10);

        return view('admin.users', [
            'name' => $adminUser->name,
            'role' => $adminUser->role,
            'users' => $users
        ]);
    }

    public function infoUser($id) {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('login')->withErrors('Please Login first...!.');
        }

        $adminUser = Auth::guard('admin')->user();

        $user = User::with(['userDetails'])->findOrFail($id);

        // Retrieve transactions involving the user
        $transactions = Transaction::where(function($query) use ($id) {
            $query->where('user_id', $id)
                ->orWhere('recipient_id', $id);
        })->orderBy('created_at', 'desc')->get();

        $transactionHashes = $transactions->pluck('transaction_hash')->unique();

        $feesData = FeesCounter::whereIn('transaction_hash', $transactionHashes)->get()->groupBy('transaction_hash');

        $totalFees = $feesData->reduce(function ($carry, $items) {
            foreach ($items as $item) {
                $carry += $item->total_fee;
            }
            return $carry;
        }, 0);

        // Fetch all staking records for this user
        $stakings = $user->stakings()->get(); // Only active stakes

        // Prepare structured staking data
        $stakingData = $stakings->map(function ($staking, $index) {


            $depositDate = Carbon::parse($staking->DepositTime);
            $withdrawnDate = Carbon::parse($staking->withdrawnTime);

            $timeDifference = now()->diffInDays($withdrawnDate);


            return [
                'stake_no' => $index + 1, // 1-based indexing for stakes
                'stake_amount' => $staking->investedAmount,
                'roaming_day' => max($timeDifference, 0), // Ensure no negative days
                'deposit_time' => $depositDate,
                'withdrawn' => $staking->unstake,
            ];
        });

        // Calculate total staking sum for only active stakes
        $totalStakingSum = $stakingData->where('withdrawn', false)
        ->sum('stake_amount');

        // Calculate total staking sum for only active stakes
        $totalunstakeSum = $stakingData->where('withdrawn', true)
        ->sum('stake_amount');

        // Fetch referral rewards
        $referralRewards = ReferralReward::where('referrer_id', $id)->get();

        // Fetch staking rewards
        $stakingRewards = StakingReward::where('user_id', $id)->get();

        return view('admin.user_edit', [
            'name' => $adminUser->name,
            'role' => $adminUser->role,
            'user' => $user,
            'referredUsersCount' => $user->referrals()->count(),
            'transactions' => $transactions,
            'feesData' => $feesData,
            'totalFees' => $totalFees,
            'stakingData' => $stakingData,
            'totalStakingSum' => $totalStakingSum,
            'totalunstakeSum' => $totalunstakeSum,
            'referralRewards' => $referralRewards,
            'stakingRewards' => $stakingRewards

        ]);
    }

    public function edit($id)
    {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('login')->withErrors('Please Login first...!.');
        }

        $adminUser = Auth::guard('admin')->user();

        $user = User::findOrFail($id);
        return view('admin.edit', [
            'user' => $user,
            'name' => $adminUser->name,
            'role' => $adminUser->role
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        $userDetails = $user->userDetails;
        $userDetails->account_status = $request->status;
        $userDetails->save();

        return redirect()->route('admin.user.list')->with('success', 'User updated successfully');
    }
}
