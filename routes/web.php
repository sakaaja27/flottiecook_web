<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RecipesCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReciptController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isUser;
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
    // news recipes
    Route::get('/news-recipes','getrecipespublished')->name('page.news-recipes');
});

Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'verified', isAdmin::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/chart-data/{type}', [DashboardController::class, 'getChartData'])->name('getChartData');
    // users management
    Route::get('/dashboard/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/dashboard/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/dashboard/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::POST('/users-reset/{id}', [UserController::class, 'reset'])->name('user.reset');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('/dashboard/recipes_category', [RecipesCategoryController::class, 'index'])->name('recipe.category.index');
    Route::get('/dashboard/recipes_category/create', [RecipesCategoryController::class, 'create'])->name('recipe.category.create');
    Route::post('/recipes_category/store', [RecipesCategoryController::class, 'store'])->name('recipe.category.store');
    Route::get('/dashboard/recipes_category/{id}/edit', [RecipesCategoryController::class, 'edit'])->name('recipe.category.edit');
    Route::put('/recipes_category/{id}', [RecipesCategoryController::class, 'update'])->name('recipe.category.update');
    Route::delete('/recipes_category/{id}', [RecipesCategoryController::class, 'destroy'])->name('recipe.category.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/publish-recipe', [LandingPageController::class, 'recipes'])->name('page.recipes');
    Route::post('/publishrecipe/store', [LandingPageController::class, 'store'])->name('page.recipes.store');
    Route::get('/dashboard/recipt', [ReciptController::class, 'index'])->name('recipt.index');
    Route::get('/dashboard/recipt/create', [ReciptController::class, 'create'])->name('recipt.create');
    Route::post('/recipt/store', [ReciptController::class, 'store'])->name('recipt.store');
    // Route::post('/recipt/store', [ReciptController::class, 'store'])->middleware('auth');
    Route::put('/recipt/{id}', [ReciptController::class, 'update'])->name('recipt.update');
    Route::get('/dashboard/recipt/{id}/edit', [ReciptController::class, 'edit'])->name('recipt.edit');
    Route::delete('recipt/{id}', [ReciptController::class, 'destroy'])->name('recipt.delete');
    Route::delete('/recipt/image/{id}', [ReciptController::class, 'destroyimage'])->name('recipt.image.destroy');
    Route::get('/recipt/{id}', [ReciptController::class, 'show'])->name('recipt.show');
    Route::post('/recipt/approved_rejected/{id}', [ReciptController::class, 'approvedRejected'])->name('recipt.approve');

    // history
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('/history/{id}', [HistoryController::class, 'show'])->name('history.show');
    Route::get('/history/{id}/edit', [HistoryController::class, 'edit'])->name('history.edit');
    Route::put('/history/{id}', [HistoryController::class, 'update'])->name('history.update');
    Route::post('/history/store', [HistoryController::class, 'store'])->name('history.store');
    // Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.delete');
    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');

    Route::post('/history/approved_rejected/{id}', [HistoryController::class, 'approvedRejected'])->name('history.approve');




});







require __DIR__ . '/auth.php';


// Route::get('/users', function() {
//     return 'Test Route';
// });
