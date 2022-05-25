<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

//Route::get('/register', [App\Http\Controllers\Auth\LoginController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/lang/{lang}',  [App\Http\Controllers\UserSettingsController::class, 'changeLang'])->name('changelang');


    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'index'])->name('user.index')->middleware('role:admin');
        Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create')->middleware('role:admin');
        Route::post('/create', [App\Http\Controllers\UserController::class, 'store'])->name('user.store')->middleware('role:admin');
        Route::get('/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->where('user', '[0-9]+')->name('user.edit')->middleware('role:admin|user');
        Route::post('/{user}/edit', [App\Http\Controllers\UserController::class, 'update'])->where('user', '[0-9]+')->name('user.update')->middleware('role:admin|user');
    });

    Route::group(['prefix' => 'ajax'], function () {
        Route::get('users/search/{searchTerm}', [App\Http\Controllers\AjaxController::class, 'searchUser'])->name('users.search')->middleware('role:admin');
    });

    Route::post('changepwd',  [App\Http\Controllers\UserController::class, 'changePassword'])->name('changePassword');
});
