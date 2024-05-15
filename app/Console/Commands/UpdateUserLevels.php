<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Level;

class UpdateUserLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:userlevels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user levels based on their total investments';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $totalInvestmentSum = $user->getTotalInvestments(); // Using the hypothetical getTotalInvestments method from User model
            $this->updateLevel($user, $totalInvestmentSum);
        }
    }

    /**
     * Update the user's level based on the total investment sum.
     *
     * @param User $user
     * @param float $totalInvestmentSum
     * @return void
     */
    protected function updateLevel(User $user, $totalInvestmentSum) {
        $newLevel = $this->calculateLevel($totalInvestmentSum);
        if ($user->userDetails->level !== $newLevel) {
            $user->userDetails->level = $newLevel;
            $user->userDetails->save();
            $this->info('Updated level to ' . $newLevel . ' for user: ' . $user->name);
        } else {
            $this->info('No level update required for user: ' . $user->name);
        }
    }

    /**
     * Determine the user's level based on the total investment sum.
     *
     * @param float $totalInvestmentSum
     * @return int
     */
    protected function calculateLevel($totalInvestmentSum) {
        // Fetch levels from the database ordered by threshold
        $levels = Level::orderBy('threshold', 'asc')->get();

        // Determine the correct level based on total investments
        $userLevel = 0;
        foreach ($levels as $level) {
            if ($totalInvestmentSum >= $level->threshold) {
                $userLevel = $level->id; // Assuming the level id is the desired value for user level
            } else {
                break; // Stop the loop once the investment sum does not meet the higher threshold
            }
        }

        return $userLevel;
    }
}
