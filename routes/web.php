<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/location')->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('location', LocationController::class);
});

Route::controller(LikeController::class)->group(function () {
    Route::post('/likes/{locationId}', 'store')->name('likes.store');
    Route::delete('/likes/{locationId}', 'destroy')->name('likes.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
