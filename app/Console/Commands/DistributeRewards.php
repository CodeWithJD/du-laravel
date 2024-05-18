<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Level;
use App\Models\RewardSetting;
use App\Models\StakingReward;
use App\Models\ReferralReward;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DistributeRewards extends Command
{
    protected $signature = 'rewards:distribute';
    protected $description = 'Distribute rewards to users based on their staking and update levels accordingly.';

    public function handle()
    {
        $rewardSettings = RewardSetting::first();
        $staking200dReward = $rewardSettings->staking_200d_reward;
        $staking400dReward = $rewardSettings->staking_400d_reward;
        $today = Carbon::today()->toDateString();

        $users = User::with(['userDetails', 'stakings' => function ($query) {
            $query->where('unstake', false);
        }])->get();

        foreach ($users as $user) {
            $totalReward = 0;

            foreach ($user->stakings as $staking) {
                // Skip if already rewarded today
                if ($staking->last_reward_date == $today) {
                    continue;
                }

                if ($staking->timeframe == 200) {
                    $reward = $staking->investedAmount * ($staking200dReward / 100);
                } elseif ($staking->timeframe == 400) {
                    $reward = $staking->investedAmount * ($staking400dReward / 100);
                } else {
                    $reward = 0;
                }

                if ($reward > 0) {
                    $totalReward += $reward;

                    // Save staking reward
                    StakingReward::create([
                        'user_id' => $user->id,
                        'staking_id' => $staking->staking_id,
                        'reward_amount' => $reward,
                    ]);

                    // Update last reward date
                    $staking->last_reward_date = $today;
                    $staking->reward_paid += $reward;
                    $staking->save();
                }
            }

            if ($totalReward > 0) {
                // Update user's reward balance
                $user->userDetails->reward_balance += $totalReward;
                $user->userDetails->save();

                // Distribute reward to referral levels
                $this->distributeReferralRewards($user, $totalReward);
            }
        }
    }

    protected function distributeReferralRewards(User $user, $totalReward)
    {
        $levelRewards = DB::table('level_rewards')->first();

        $referralUser = $user;
        for ($level = 1; $level <= 12; $level++) {
            $referralUser = User::find($referralUser->ref_id);

            if (!$referralUser) {
                break;
            }

            $referrerDetails = $referralUser->userDetails;
            if ($referrerDetails->level >= $level) {
                $rewardPercentage = $levelRewards->{'level_' . $level};
                $referralReward = $totalReward * ($rewardPercentage / 100);

                if ($referralReward > 0) {
                    $referrerDetails->reward_balance += $referralReward;
                    $referrerDetails->team_reward += $referralReward;
                    $referrerDetails->save();

                    // Save referral reward
                    ReferralReward::create([
                        'referrer_id' => $referralUser->id,
                        'referee_id' => $user->id,
                        'level' => $level,
                        'reward_amount' => $referralReward,
                    ]);
                }
            }
        }
    }
}
