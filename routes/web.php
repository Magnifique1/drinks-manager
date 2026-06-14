<?php

use App\Http\Controllers\DrinksController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('index');
Route::get('/sub/cat/{sub_cat_id}', [HomeController::class, 'filterMenuItems'])->name('filterMenuItems');
Route::post('/create-new-drink', [HomeController::class, 'newDrink'])
    ->middleware('auth')
    ->name('newDrink');
Route::post('/delete-drink', [HomeController::class, 'deleteDrink'])
    ->middleware('auth')
    ->name('deleteDrink');
Route::post('/update-drink', [HomeController::class, 'updateDrink'])
    ->middleware('auth')
    ->name('updateDrink');

Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');
