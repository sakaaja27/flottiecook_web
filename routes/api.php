<?php

use App\Http\Controllers\api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserApiController::class, 'index'])->name('api.users');
Route::post('/users/store',[UserApiController::class,'store'])->name('api.usersstore');
Route::post('/users/login',[UserApiController::class,'login'])->name('api.login');


