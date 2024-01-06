<?php

use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\RoomController;
use Illuminate\Support\Facades\Route;

// អាកន្លែង index ហ្នឹង គឺជាឈ្មោះ function index ដែលនៅក្នុង HomeController 
Route::get('/', [HomeController::class, 'index']);

Route::controller(RoomController::class)->group(function(){
    Route::get('room', 'index');
});