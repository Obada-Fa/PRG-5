<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShiftController;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::get('/dashboard', function () {
    return view('home');
})->name('dashboard');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Shift resource routes, accessible only to authenticated users
Route::middleware(['auth'])->group(function () {
    Route::resource('shifts', ShiftController::class);
});
Route::post('/shifts/{shift}/toggle-status', [ShiftController::class, 'toggleStatus'])->name('shifts.toggleStatus');
Route::post('/shifts/{id}/apply', [ShiftController::class, 'apply'])->middleware('auth')->name('shifts.apply');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

