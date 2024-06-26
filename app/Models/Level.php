<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'levels';

    // Specify the fields that can be mass assigned
    protected $fillable = [
        'name',
        'threshold',
        // Add any other fields present in the levels table
    ];
}
