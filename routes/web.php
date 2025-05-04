<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/dashboard_user', function () {
    return view('etudiant/dashboard_user'); // interface d'acceuil de  l'étudiant
})->middleware('auth')->name('dashboard_user');

Route::get('/dashboardAdmin', function () {
    return view('admin/dashboardAdmin'); // Tableau de bord admin
})->middleware('auth');

// routes pour la gestion des notes
Route::middleware(['auth'])->group(function () {
    // Routes pour la gestion des notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index'); // Liste des notes
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create'); // Formulaire de création
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store'); // Enregistrer une nouvelle note
    Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show'); // Afficher une note
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit'); // Formulaire de modification
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update'); // Mettre à jour une note
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy'); // Supprimer une note
  
    // Route pour l'importation depuis un fichier TXT
    Route::post('/notes/import-txt', [NoteController::class, 'importTxt'])->name('notes.import-txt');
    // À l'intérieur du groupe de routes middleware(['auth'])
    Route::get('/notesy', function() {
        return view('notes.import');
    })->name('notesy');
   });

// Ajout d'une redirection de /index vers /notes
Route::get('/index', function () {
    return redirect('/notes');
});
// routes pour la gestion des quiz
Route::middleware(['auth'])->group(function () {
    Route::resource('quizzes', QuizController::class);
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create');

    // Routes pour les questions
    Route::get('quizzes/{quiz}/questions/create', [QuizController::class, 'createQuestion'])->name('quizzes.questions.create');
    Route::post('quizzes/{quiz}/questions', [QuizController::class, 'storeQuestion'])->name('quizzes.questions.store');
    Route::get('quizzes/{quiz}/questions/{question}/edit', [QuizController::class, 'editQuestion'])->name('quizzes.questions.edit');
    Route::put('quizzes/{quiz}/questions/{question}', [QuizController::class, 'updateQuestion'])->name('quizzes.questions.update');
    Route::delete('quizzes/{quiz}/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('quizzes.questions.destroy');
});
// routes pour la gestion des flashcards
Route::middleware(['auth'])->group(function () {
    Route::resource('flashcards', FlashcardController::class);
// routes pour les cartes flash
    Route::prefix('flashcards/{flashcard}')->group(function () {
        Route::resource('cards', CardController::class)->except(['index']);
    });
    // Routes pour la révision des flashcards
    Route::middleware(['auth'])->group(function () {
        Route::get('/review/deck/{flashcard}', [ReviewController::class, 'reviewDeck'])->name('reviews.deck');
        Route::post('/review/process/{card}', [ReviewController::class, 'processReview'])->name('reviews.process');
    });

    // Routes pour la Génération IA à partir des Notes
    Route::post('/notes/{note}/generate-quiz', [NoteController::class, 'generateQuiz'])
          ->name('notes.ai.generate.quiz');

    Route::post('/notes/{note}/generate-flashcards', [NoteController::class, 'generateFlashcards'])
          ->name('notes.ai.generate.flashcards');
});


