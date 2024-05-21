<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StakingReward;
use App\Models\ReferralReward;
use Illuminate\Support\Facades\Auth;


class ActivitiesController extends Controller
{
    public function show() {

        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        $referralRewards = ReferralReward::where('referrer_id', $user->id)->orWhere('referee_id', $user->id)->get();

        $referralRewards = ReferralReward::where('referrer_id', $user->id)
                                        ->orWhere('referee_id', $user->id)
                                        ->with(['referrer', 'referee'])
                                        ->get();



        return view('dashboard.activities', [
            'name' => $user->name,
            'referralRewards' => $referralRewards,
                ]);
    }
}
