<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserDetails;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Balance etc info
        $userDetails = UserDetails::where('user_id', $user->id)->first();

        // Fetch all staking records for this user
        $stakings = $user->stakings()->where('unstake', false)->get(); // Only active stakes

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

        // Calculate total staking sum
        $totalStakingSum = $stakingData->sum('stake_amount');

        // Calculate total team size
        $totalTeamSize = $user->getTotalReferralsCount();

        // Retrieve counts and investments for all levels up to One
        $directsInvestmentSum = $user->directsInvestments();

        // Retrieve counts and investments for all levels up to Two
        $levelTwoReferralsCount = $user->levelTwoReferralsCount();
        $levelTwoInvestmentSum = $user->levelTwoInvestments();

        // Retrieve counts and investments for all levels up to There
        $levelThreeReferralsCount = $user->levelThreeReferralsCount();
        $levelThreeInvestmentSum = $user->levelThreeInvestments();

        // Retrieve counts and investments for all levels up to Fout
        $levelFourReferralsCount = $user->levelFourReferralsCount();
        $levelFourInvestmentSum = $user->levelFourInvestments();

        // Retrieve counts and investments for all levels up to Five
        $levelFiveReferralsCount = $user->levelFiveReferralsCount();
        $levelFiveInvestmentSum = $user->levelFiveInvestments();

        // Retrieve counts and investments for all levels up to Six
        $levelSixReferralsCount = $user->levelSixReferralsCount();
        $levelSixInvestmentSum = $user->levelSixInvestments();

        // Retrieve counts and investments for all levels up to Seven
        $levelSevenReferralsCount = $user->levelSevenReferralsCount();
        $levelSevenInvestmentSum = $user->levelSevenInvestments();

        // Retrieve counts and investments for all levels up to Eight
        $levelEightReferralsCount = $user->levelEightReferralsCount();
        $levelEightInvestmentSum = $user->levelEightInvestments();

        // Retrieve counts and investments for all levels up to Nine
        $levelNineReferralsCount = $user->levelNineReferralsCount();
        $levelNineInvestmentSum = $user->levelNineInvestments();

        // Retrieve counts and investments for all levels up to Ten
        $levelTenReferralsCount = $user->levelTenReferralsCount();
        $levelTenInvestmentSum = $user->levelTenInvestments();

        // Retrieve counts and investments for all levels up to Eleven
        $levelElevenReferralsCount = $user->levelElevenReferralsCount();
        $levelElevenInvestmentSum = $user->levelElevenInvestments();

        // Retrieve counts and investments for all levels up to TwelveRe
        $levelTwelveReferralsCount = $user->levelTwelveReferralsCount();
        $levelTwelveInvestmentSum = $user->levelTwelveInvestments();

        // Calculate the total investment sum across all levels
        $totalInvestmentSum = $directsInvestmentSum +
                              $levelTwoInvestmentSum +
                              $levelThreeInvestmentSum +
                              $levelFourInvestmentSum +
                              $levelFiveInvestmentSum +
                              $levelSixInvestmentSum +
                              $levelSevenInvestmentSum +
                              $levelEightInvestmentSum +
                              $levelNineInvestmentSum +
                              $levelTenInvestmentSum +
                              $levelElevenInvestmentSum +
                              $levelTwelveInvestmentSum;


        return view('dashboard.index', [
            'name' => $user->name,
            'invite_code' => $user->invite_code,
            'userDetails' => $userDetails,
            'referredUsersCount' => $user->referrals()->count(),
            'totalTeamSize' => $totalTeamSize,
            'stakingData' => $stakingData,
            'totalStakingSum' => $totalStakingSum, // Pass total staking sum to the view
            'totalInvestmentSum' => $totalInvestmentSum,
            'directsInvestmentSum' => $directsInvestmentSum,
            'levelTwoReferralsCount' => $levelTwoReferralsCount,
            'levelTwoInvestmentSum' => $levelTwoInvestmentSum,
            'levelThreeReferralsCount' => $levelThreeReferralsCount,
            'levelThreeInvestmentSum' => $levelThreeInvestmentSum,
            'levelFourReferralsCount' => $levelFourReferralsCount,
            'levelFourInvestmentSum' => $levelFourInvestmentSum,
            'levelFiveReferralsCount' => $levelFiveReferralsCount,
            'levelFiveInvestmentSum' => $levelFiveInvestmentSum,
            'levelSixReferralsCount' => $levelSixReferralsCount,
            'levelSixInvestmentSum' => $levelSixInvestmentSum,
            'levelSevenReferralsCount' => $levelSevenReferralsCount,
            'levelSevenInvestmentSum' => $levelSevenInvestmentSum,
            'levelEightReferralsCount' => $levelEightReferralsCount,
            'levelEightInvestmentSum' => $levelEightInvestmentSum,
            'levelNineReferralsCount' => $levelNineReferralsCount,
            'levelNineInvestmentSum' => $levelNineInvestmentSum,
            'levelTenReferralsCount' => $levelTenReferralsCount,
            'levelTenInvestmentSum' => $levelTenInvestmentSum,
            'levelElevenReferralsCount' => $levelElevenReferralsCount,
            'levelElevenInvestmentSum' => $levelElevenInvestmentSum,
            'levelTwelveReferralsCount' => $levelTwelveReferralsCount,
            'levelTwelveInvestmentSum' => $levelTwelveInvestmentSum,
        ]);
    }
}
