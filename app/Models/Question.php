<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'correct_answer',
        'incorrect_answers',
        'type',
        'quiz_id'
    ];

    protected $casts = [
        'incorrect_answers' => 'array',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
