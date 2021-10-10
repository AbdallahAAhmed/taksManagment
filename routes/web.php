<?php

use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\dashboardController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\Front\indexController;
use App\Http\Controllers\admin\UserController;
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


Route::group(
    ['prefix' => 'dashboard', 'namespace' => 'admin'],
    function () {
        Route::group(['middleware' => ['auth:web']], function () {
            Route::get('/', [dashboardController::class, 'index'])->name('dashboard.index');
            //category routes
            Route::group(['prefix' => 'categories'], function () {
                Route::get('/', [CategoriesController::class, 'index'])->name('categories');
                Route::post('/AjaxDT', [CategoriesController::class, 'AjaxDT']);
                Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
                Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store');
                Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
                Route::put('/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
                Route::get('/delete/{id}', [CategoriesController::class, 'delete'])->name('categories.delete');
            });
            //user routes
             Route::group(['prefix' => 'users'], function () {
                Route::get('/', [UserController::class, 'index'])->name('users');
                Route::post('/AjaxDT', [UserController::class, 'AjaxDT']);
                Route::get('/create', [UserController::class, 'create'])->name('users.create');
                Route::post('/store', [UserController::class, 'store'])->name('users.store');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
                Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
                Route::get('/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
            });

            //project routes
            Route::group(['prefix' => 'projects'], function () {
                Route::get('/', [ProjectController::class, 'index'])->name('projects');
                Route::post('/AjaxDT', [ProjectController::class, 'AjaxDT']);
                Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
                Route::post('/store', [ProjectController::class, 'store'])->name('projects.store');
                Route::get('/edit/{id}', [ProjectController::class, 'edit'])->name('projects.edit');
                Route::put('/update/{id}', [ProjectController::class, 'update'])->name('projects.update');
                Route::get('/delete/{id}', [ProjectController::class, 'delete'])->name('projects.delete');
            });
        });
    }
);

//authentication routes
Route::get('/user-register', [RegisterController::class, 'register'])->name('user.register');
Route::post('/user-store', [RegisterController::class, 'store'])->name('user.store');
Route::get('/user-login', [LoginController::class, 'showLogin'])->name('show.login');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');
Route::post('logout', [LoginController::class, 'logout'])->name('user.logout');
