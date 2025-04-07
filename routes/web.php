<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;

Route::controller(LandingPageController::class)->group(function(){
    Route::get('/','home')->name('page.home');
});

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// for user
Route::get('/users', [UserController::class, 'index'])->name('user');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::resource('user', UserController::class);
Route::delete('user/{id}', [UserController::class, 'destroy'])->name('delete.user');
Route::get('user/create', [UserController::class, 'create'])->name('users.create');


// Route::get('/users', function() {
//     return 'Test Route';
// });
