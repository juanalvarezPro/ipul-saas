<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;

Route::redirect('/', '/admin'); 

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('/auth/google', [SocialLoginController::class, 'redirectToProvider']);
Route::get('/auth/google/callback', [SocialLoginController::class, 'socialCallback']);
