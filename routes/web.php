<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('index');

Route::resource('location', LocationController::class);
