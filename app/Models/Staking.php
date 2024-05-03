<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'investedAmount',
        'DepositTime',
        'withdrawnTime',
        'reward_paid',
        'unstake',
        'timeframe',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the staking.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
