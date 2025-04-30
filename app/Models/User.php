<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Note;
use App\Models\Groupe;
use App\Models\Message;
use App\Models\Statistique;
use App\Models\Quiz;
use App\Models\Flashcard;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo_profil',
        'role',
        'est_actif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'est_actif' => 'boolean',
        ];
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class); // Assure-toi que le modèle Quiz existe
    }
    // public function matieres()
    // {
    //     return $this->hasMany(::class);
    // }
    
    /**
     * Define the relationship with flashcards
     */
    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }
}
