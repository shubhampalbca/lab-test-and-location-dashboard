<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DropdownController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DropdownController::class, 'index']);

Route::get('lab-test', [UserController::class, 'index']);
Route::get('parent_lab_test/{id}', [UserController::class, 'parent_lab_test']);
Route::post('lab-test', [UserController::class, 'lab_test']);



Route::get('dependent-dropdown', [DropdownController::class, 'index']); //  This passes the data!
Route::post('api/fetch-states', [DropdownController::class, 'fetchState']);
Route::post('api/fetch-cities', [DropdownController::class, 'fetchCity']);
// Route to handle the form submission data
Route::post('store-dropdown', [DropdownController::class, 'store'])->name('dropdown.store');