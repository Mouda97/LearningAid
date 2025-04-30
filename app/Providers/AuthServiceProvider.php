<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Support\Facades\Log; // Correction de la capitalisation ici

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view-quiz', function (User $user, Quiz $quiz) {
            Log::info('View Quiz Gate: User ID = ' . $user->id . ', Quiz User ID = ' . $quiz->user_id);
            // Temporairement, autoriser tout le monde à voir les quiz
            return true; // Pour déboguer, autoriser tout le monde
            // return $user->id === $quiz->user_id;
        });

        Gate::define('update-quiz', function (User $user, Quiz $quiz) {
            Log::info('Update Quiz Gate: User ID = ' . $user->id . ', Quiz User ID = ' . $quiz->user_id);
            // Temporairement, autoriser tout le monde à modifier les quiz
            return true; // Pour déboguer, autoriser tout le monde
            // return $user->id === $quiz->user_id;
        });

        Gate::define('delete-quiz', function (User $user, Quiz $quiz) {
            Log::info('Delete Quiz Gate: User ID = ' . $user->id . ', Quiz User ID = ' . $quiz->user_id);
            // Temporairement, autoriser tout le monde à supprimer les quiz
            return true; // Pour déboguer, autoriser tout le monde
            // return $user->id === $quiz->user_id;
        });
    }
 }