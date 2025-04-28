<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;


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



