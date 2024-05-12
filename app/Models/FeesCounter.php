<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesCounter extends Model
{
    protected $table = 'fees_counter'; // Ensure the model uses the correct table

    protected $fillable = [
        'fee_type', 'total_fee', 'transaction_hash', 'created_at', 'updated_at'
    ];
}
