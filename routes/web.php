<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\RoomController;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    // អាកន្លែង index ហ្នឹង គឺជាឈ្មោះ function index ដែលនៅក្នុង HomeController 
    Route::get('/', [HomeController::class, 'index']);

    Route::controller(RoomController::class)->group(function () {
        Route::get('room', 'index');
        Route::get('room/create', 'create');
        Route::get(('room/edit/{id}'), 'edit');
        Route::post('room/save', 'save');
        Route::post('room/update', 'update');

        Route::get('room/search', 'search')->name('room.search');

        Route::get('room/delete/{id}', 'delete')->name('room.delete');
    });
});


// Login with built-in laravel auth
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login/post', 'postLogin')->name('login.post');
    Route::get('logout', 'logout')->name('logout');
});
