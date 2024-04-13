<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DatatableController;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\UserController;
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

    Route::get('datatable_rooms', [DatatableController::class,  'index']);
    Route::get('getRoom', [DatatableController::class,  'getRoom'])->name('getRoom');

    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index');
        Route::post('users/reset-password', 'resetPassword')->name('users.reset-password');
    });
});


// Login with built-in laravel auth
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('login/post', 'postLogin')->name('login.post');

    Route::get('register', 'registration')->name('registration');
    Route::post('post-register', 'postRegistration')->name('registration.post');

    Route::get('logout', 'logout')->name('logout');
});
