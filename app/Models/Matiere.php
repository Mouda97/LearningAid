<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Note;

class Matiere extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // public function quizzes()
    // {
    //     return $this->hasMany(Quiz::class);
    // }

    // public function flashcards()
    // {
    //     return $this->hasMany(Flashcard::class);
    // }
}

