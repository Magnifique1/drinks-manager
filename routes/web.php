<?php

use App\Http\Controllers\DrinksController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DrinksController::class, 'index'])->name('index');
Route::get('/sub/cat/{sub_cat_id}', [DrinksController::class, 'filterMenuItems'])->name('filterMenuItems');
Route::post('/create-new-drink', [DrinksController::class, 'newDrink'])->name('newDrink');
Route::post('/delete-drink', [DrinksController::class, 'deleteDrink'])->name('deleteDrink');
Route::post('/update-drink', [DrinksController::class, 'updateDrink'])->name('updateDrink');
