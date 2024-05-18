<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StakingReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staking_id',
        'reward_amount',
    ];
}
