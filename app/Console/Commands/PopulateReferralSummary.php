<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PopulateReferralSummary extends Command
{
    protected $signature = 'referral:populate-summary';
    protected $description = 'Populates the user_referrals_summary table with total referral counts.';

    public function handle()
    {
        $this->info('Starting to populate referral summary...');

        // Fetch all users
        $users = User::all();

        foreach ($users as $user) {
            // Calculate total referrals for each user
            $totalReferrals = $this->calculateTotalReferralsForUser($user);

            // Insert/Update the summary table
            DB::table('user_referrals_summary')->updateOrInsert(
                ['user_id' => $user->id],
                ['total_referrals' => $totalReferrals]
            );

            $this->info("Processed user {$user->id} with {$totalReferrals} total referrals.");
        }

        $this->info('Referral summary population complete.');
    }

    private function calculateTotalReferralsForUser(User $user)
    {
        // Recursive method to calculate referrals, assuming method exists in User model
        return $user->getTotalReferralsCount();
    }
}
