<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavedDada extends Model
{
    /** @use HasFactory<\Database\Factories\SavedDadaFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function first_play_title(): BelongsTo
    {
        return $this->belongsTo(Work::class, 'first_play', 'WorkID');
    }

    public function second_play_title(): BelongsTo
    {
        return $this->belongsTo(Work::class, 'second_play', 'WorkID');
    }

    public function remove_character_name(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'remove_character', 'CharID');
    }

    public function add_character_name(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'add_character', 'CharID');
    }
}
