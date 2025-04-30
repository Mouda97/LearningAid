<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'note_id',
        'user_id',
    ];

    /**
     * Get the user that owns this flashcard set.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the note associated with this flashcard set.
     */
    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }

    /**
     * Get the cards for this flashcard set.
     */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}

