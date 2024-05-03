<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deposit_wallet',
        'withdrawal_wallet',
        'available_balance',
        'reward_balance',
        'whatsapp_notification',
        'profile_image',
        'account_status',
        'email_verified',
        'mobile_verified',
    ];

    public $timestamps = false; // Disable automatic timestamps

}
