<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staking;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class AdminDashboardController extends Controller
{
    public function adminDashboard() {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('login')->withErrors('Please Login first...!.');
        }

        $adminUser = Auth::guard('admin')->user();

        // Data calculations
        $totalUsers = User::count();
        $totalAvailableBalance = UserDetails::sum('available_balance');
        $totalUsersWithStaking = Staking::distinct('user_id')->where('unstake', false)->count();

        // Calculate the staking data for the last 12 months
        $monthlyData = [];
        $totalStake = 0; // Initialize total stake amount
        $totalUnstake = 0; // Initialize total unstake amount
        for ($i = 0; $i < 12; $i++) {
            $month = Carbon::now()->subMonths($i);
            $startOfMonth = $month->startOfMonth()->toDateString();
            $endOfMonth = $month->endOfMonth()->toDateString();

            $monthStake = Staking::where('unstake', false)
                                 ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                 ->sum('investedAmount');
            $monthUnstake = Staking::where('unstake', true)
                                   ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                                   ->sum('investedAmount');

            // Accumulating the totals
            $totalStake += $monthStake;
            $totalUnstake += $monthUnstake;

            $monthlyData[] = [
                'month' => $month->format('F Y'),
                'stakeAmount' => $monthStake,
                'unstakeAmount' => $monthUnstake
            ];
        }

        // Reverse the array to start from the latest month
        $monthlyData = array_reverse($monthlyData);

        // Device type counts using optimized database queries
        $deviceCounts = [
            'mobile' => UserDetails::where('last_login_device', 'LIKE', '%Mobile%')->count(),
            'tablet' => UserDetails::where('last_login_device', 'LIKE', '%Tablet%')->count(),
            'desktop' => UserDetails::whereRaw("last_login_device NOT LIKE '%Mobile%' AND last_login_device NOT LIKE '%Tablet%'")->count(),
        ];

        return view('admin.dashboard', [
            'name' => $adminUser->name,
            'role' => $adminUser->role,
            'totalUsers' => $totalUsers,
            'totalAvailableBalance' => $totalAvailableBalance,
            'totalUsersWithStaking' => $totalUsersWithStaking,
            'monthlyData' => $monthlyData,
            'totalStake' => $totalStake,
            'totalUnstake' => $totalUnstake,
            'deviceCounts' => $deviceCounts,
        ]);
    }
}
