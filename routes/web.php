<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Front\indexController;
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


Route::group(['namespace' => 'Front'], function () {
    Route::get('/', [
        indexController::class, 'index'
    ])->name('home.index');
});

//authentication routes
Route::get('/user-register', [RegisterController::class, 'register'])->name('user.register');
Route::post('/user-store', [RegisterController::class, 'store'])->name('user.store');
Route::get('/user-login', [LoginController::class, 'showLogin'])->name('show.login');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');
Route::post('logout', [LoginController::class, 'logout'])->name('user.logout');
