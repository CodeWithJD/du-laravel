<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserDetails;

class ResetDailyTransferUsed extends Command
{
    protected $signature = 'reset:dailytransfer';
    protected $description = 'Reset daily transfer used and daily withdrawal limit for all users';

    public function handle()
    {
        UserDetails::query()->update([
            'daily_reward_transfer_used' => 0,
            'daily_withdrawal_limit' => 0
        ]);

        $this->info('Daily transfer used and daily withdrawal limits have been reset.');
    }
}
