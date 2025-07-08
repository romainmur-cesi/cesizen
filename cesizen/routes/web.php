<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;

// Page d'accueil = formulaire de login (même si pas connecté)
Route::get('/', function () {
    return view('auth.login'); // ton fichier Blade : resources/views/auth/login.blade.php
})->name('login');

// Page "accueil après connexion"
Route::get('/index', function () {
    return view('welcome'); // ton fichier Blade : resources/views/welcome.blade.php
})->name('welcome');

// Page tableau de bord (si tu veux l’utiliser plus tard)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Inscription
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Réinitialisation mot de passe
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Profil utilisateur (tu peux commenter si non utilisé)
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Page Exercice (module respiration etc.)
Route::get('/exercice', function () {
    return view('exercises.exercice');
});

// Inclusion des routes auth Laravel (si installées via Breeze ou Jetstream)
require __DIR__.'/auth.php';