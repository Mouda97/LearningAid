<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardUserReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_id',
        'ease_factor',
        'interval',
        'repetitions',
        'next_review_at'
    ];

    protected $casts = [
        'next_review_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}