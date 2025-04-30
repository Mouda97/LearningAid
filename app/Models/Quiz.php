<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'statut',
        'nombre_questions',
        'temps_limite',
        'user_id',
        'note_id',
        'visibilite',
        'completed'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}

