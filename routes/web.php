<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[\App\Http\Controllers\HomeController::class,'index'])->name('home');

Route::group(['middleware'=>'guest'],function (){
    Route::get('/register',[\App\Http\Controllers\UserController::class,'index'])->name('register-create');
    Route::post('/register',[\App\Http\Controllers\UserController::class,'store'])->name('register-store');

    Route::get('/login',[\App\Http\Controllers\UserController::class,'loginForm'])->name('login');
    Route::post('/login',[\App\Http\Controllers\UserController::class,'login'])->name('login-store');
});

Route::get('/map',[\App\Http\Controllers\MapsController::class,'index'])->name('maps');
Route::get('/logout',[\App\Http\Controllers\UserController::class,'logout'])->name('logout');
Route::get('/admin',[\App\Http\Controllers\AdminController::class,'index'])->middleware('admin');
Route::get('/profile',[\App\Http\Controllers\UserController::class,'profile'])->name('profile');
