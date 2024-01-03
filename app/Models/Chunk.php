<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use MongoDB\Laravel\Eloquent\Model;

class Chunk extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
