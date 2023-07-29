<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Music extends Model
{
    use HasFactory;

    protected $table = 'musics';
    protected $fillable = [
        'album_id',
        'genre',
        'name',
        'launch_date'
    ];

    protected $casts = [
        'launch_date' => 'datetime'
    ];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function lyric(): HasOne
    {
        return $this->hasOne(Lyric::class);
    }
}
