<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Paper extends Model
{

    protected $fillable = [
        'title',
        'slug',
        'user_id',
    ];

    use HasFactory;
}
