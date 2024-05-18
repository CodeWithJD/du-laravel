<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardSetting extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'reward_settings';

    // Specify the fields that can be mass assigned
    protected $fillable = [
        'staking_200d_reward',
        'staking_400d_reward',
        'deposit_usdt_charge',
        'deposit_du_charge',
        // Add any other fields present in the reward_settings table
    ];
}
