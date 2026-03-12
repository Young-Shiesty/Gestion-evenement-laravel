<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//mm quand le user n'est pas connectee il peut voir les evenements
Route::get('/evenements', [EvenementController::class, 'index'])->name('evenements.index');
Route::get('/evenements/{evenement}', [EvenementController::class, 'afficher'])->name('evenements.afficher');
// le middleware pour securisee cad seul les connectee peuvent voir ces pages
Route::middleware('auth')->group(function () {
    Route::get('/evenements/creer/formulaire', [EvenementController::class, 'creer'])->name('evenements.creer');
    Route::post('/evenements', [EvenementController::class, 'sauvegarder'])->name('evenements.sauvegarder');
    Route::get('/evenements/{evenement}/editer', [EvenementController::class, 'editer'])->name('evenements.editer');
    Route::put('/evenements/{evenement}', [EvenementController::class, 'mettreAJour'])->name('evenements.mettreAJour');
    Route::delete('/evenements/{evenement}', [EvenementController::class, 'supprimer'])->name('evenements.supprimer');
});


require __DIR__.'/auth.php';


