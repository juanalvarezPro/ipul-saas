<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\SessionRevocationController;


Route::get('/logout-session/{session_id}', [SessionRevocationController::class, 'revoke'])
    ->name('logout.session');

Route::get('/auth/google', [SocialLoginController::class, 'redirectToProvider'])->name('auth.google');
Route::get('/auth/google/callback', [SocialLoginController::class, 'socialCallback']);

Route::fallback(function () {
    return redirect('/admin');
});