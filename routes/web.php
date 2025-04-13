<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReciptController;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

Route::controller(LandingPageController::class)->group(function () {
    Route::get('/', 'home')->name('page.home');
    Route::get('/aibot', 'aibot')->name('page.aibot');
    Route::post('/aibotwithimage', 'aibotwithimage')->name('page.aibotwithimage');
});

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // users management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::POST('/users-reset/{id}', [UserController::class, 'reset'])->name('user.reset');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/recipt', [ReciptController::class, 'index'])->name('recipt.index');
    Route::get('/recipt/create', [ReciptController::class, 'create'])->name('recipt.create');
    Route::post('/recipt/store', [ReciptController::class, 'store'])->name('recipt.store');
    // Route::post('/recipt/store', [ReciptController::class, 'store'])->middleware('auth');
    Route::put('/recipt/{id}', [ReciptController::class, 'update'])->name('recipt.update');
    Route::get('/recipt/{id}/edit', [ReciptController::class, 'edit'])->name('recipt.edit');
    Route::delete('recipt/{id}', [ReciptController::class, 'destroy'])->name('recipt.delete');
    Route::delete('/recipt/image/{id}', [ReciptController::class, 'destroyimage'])->name('recipt.image.destroy');

});




require __DIR__ . '/auth.php';


// Route::get('/users', function() {
//     return 'Test Route';
// });
