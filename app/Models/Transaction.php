<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_source',
        'user_id',
        'recipient_id',
        'sender_address',
        'recipient_address',
        'amount',
        'transfer_charge',
        'status',
        'transaction_hash',
        'description',
        'timestamp',
    ];

    // Define a relationship to the sender user
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define a relationship to the recipient user
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
