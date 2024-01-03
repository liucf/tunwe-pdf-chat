<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'chunks_id' => 'array',
    ];

    public function chunks()
    {
        $chunks = [];
        $chunkids = $this->chunks_id;
        foreach ($chunkids as $chunkid) {
            $chunks[] = Chunk::find($chunkid);
        }
        return $chunks;
    }
}
