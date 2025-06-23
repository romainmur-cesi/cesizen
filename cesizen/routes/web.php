<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

// Page d’accueil publique
Route::get('/', [HomeController::class, 'index'])->name('home');

// Articles accessibles à tous (visiteurs)
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Auth routes (générées par Breeze ou Laravel UI)
require __DIR__.'/auth.php';

// Groupes routes utilisateurs connectés
Route::middleware(['auth'])->group(function () {
    // Dashboard utilisateur
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Favoris, journal, exercices... (à ajouter)
});

// Groupes routes admin (middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestion des utilisateurs
    Route::resource('users', AdminUserController::class);
    // Gestion des contenus (articles, exercices...) à ajouter
});

// Articles
Route::resource('articles', ArticleController::class);

// Profil utilisateur (édition, mise à jour)
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

// Administration des utilisateurs (groupe avec middleware admin si besoin)
Route::prefix('admin')->name('admin.')->middleware('auth', 'can:admin')->group(function () {
    Route::resource('users', UserController::class);
});