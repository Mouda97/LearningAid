<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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
})->middleware('auth');

Route::get('/dashboardAdmin', function () {
    return view('admin/dashboardAdmin'); // Tableau de bord admin
})->middleware('auth');


