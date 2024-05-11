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
        'account_status',
        'email_verified',
        'mobile_verified',
        'last_login',
        'last_login_device',
        'last_login_ip',
    ];

    // Define the inverse of the relationship in UserDetails
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public $timestamps = false; // Disable automatic timestamps

}
