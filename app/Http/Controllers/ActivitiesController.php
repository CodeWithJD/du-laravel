<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralReward;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ActivitiesController extends Controller
{
    public function show() {

        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Separate queries for today rewards
        $todayReferralRewardsAsReferrer = ReferralReward::where('referrer_id', $user->id)
                                                        ->whereDate('created_at', $today)
                                                        ->sum('reward_amount');

        // Separate queries for yesterday rewards
        $yesterdayReferralRewardsAsReferrer = ReferralReward::where('referrer_id', $user->id)
                                                            ->whereDate('created_at', $yesterday)
                                                            ->sum('reward_amount');

        $referralRewards = ReferralReward::where('referrer_id', $user->id)
                                         ->orWhere('referee_id', $user->id)
                                         ->orderBy('created_at', 'desc')
                                         ->with(['referrer', 'referee'])
                                         ->paginate(10);

        return view('dashboard.activities', [
            'name' => $user->name,
            'referralRewards' => $referralRewards,
            'todayRewards' => $todayReferralRewardsAsReferrer,
            'yesterdayRewards' => $yesterdayReferralRewardsAsReferrer,
        ]);
    }
}
