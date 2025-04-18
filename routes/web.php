<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RecipesCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReciptController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\isAdmin;
use Illuminate\Foundation\Auth\User;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

Route::controller(LandingPageController::class)->group(function () {
    Route::get('/', 'home')->name('page.home');
    // aibot
    Route::get('/aibot', 'aibot')->name('page.aibot');
    Route::post('/aibotwithimage', 'aibotwithimage')->name('page.aibotwithimage');
    Route::post('/aibotwithtext', 'aibotwithtext')->name('page.aibotwithtext');
    // recipe
    Route::get('/publishrecipe', 'publishrecipe')->name('page.publishrecipe');

});

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'verified', isAdmin::class])->group(function () {
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

    Route::get('/recipes_category', [RecipesCategoryController::class, 'index'])->name('recipe.category.index');
    Route::get('/recipes_category/create', [RecipesCategoryController::class, 'create'])->name('recipe.category.create');
    Route::post('/recipes_category/store', [RecipesCategoryController::class, 'store'])->name('recipe.category.store');
    Route::get('/recipes_category/{id}/edit', [RecipesCategoryController::class, 'edit'])->name('recipe.category.edit');
    Route::put('/recipes_category/{id}', [RecipesCategoryController::class, 'update'])->name('recipe.category.update');
    Route::delete('/recipes_category/{id}', [RecipesCategoryController::class, 'destroy'])->name('recipe.category.destroy');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/publishrecipe',[LandingPageController::class, 'recipes'])->name('page.recipes');
    Route::post('/publishrecipe/store',[LandingPageController::class, 'store'])->name('page.recipes.store');
});






require __DIR__ . '/auth.php';


// Route::get('/users', function() {
//     return 'Test Route';
// });
