<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'levels'; // Specify if your table name is not the plural form of 'level'

    protected $fillable = [
        'name',
        'threshold',
    ];
}
