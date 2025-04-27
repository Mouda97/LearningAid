<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Note extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    protected $table = 'notes';

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'statut	',
        'niveau_visibilite',
        'matiere', 
    ];

   

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
//

