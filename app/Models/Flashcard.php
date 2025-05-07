<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'note_id',
        'user_id',
        'front',
        'back',
        'status',
        'visibilite'
    ];

    /**
     * Get the user that owns this flashcard.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the note associated with this flashcard.
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}

