<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lyric extends Model
{
    use HasFactory;

    protected $fillable = [
        'music_id',
        'content'
    ];

    public function music(): BelongsTo
    {
        return $this->belongsTo(Music::class);
    }
}
