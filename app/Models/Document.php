<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
// use MongoDB\Laravel\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chunks()
    {
        return $this->hasMany(Chunk::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Document $document) {
            $document->uuid = (string) Str::uuid();
        });
    }
}
