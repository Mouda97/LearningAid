<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'matiere',
        'statut',
        'niveau_visibilite',
        'user_id',
    ];

    /**
     * Get the user that owns this note.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Removing the incorrect note relationship
    // If you need a relationship to Matiere model, it should be:
    // public function matiere(): BelongsTo
    // {
    //     return $this->belongsTo(Matiere::class);
    // }
}

