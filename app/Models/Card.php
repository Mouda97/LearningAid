<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'front',
        'back',
        'flashcard_id',
        'user_id',
        'note_id',
    ];

    /**
     * Get the flashcard set that this card belongs to.
     */
    public function flashcard(): BelongsTo
    {
        return $this->belongsTo(Flashcard::class);
    }

    /**
     * Get the user that created this card.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the matiere associated with this card.
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
