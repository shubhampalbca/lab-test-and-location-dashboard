<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropdownController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Update these lines in routes/web.php to add the 'api/' prefix:
Route::post('api/fetch-states', [DropdownController::class, 'fetchState']);
Route::post('api/fetch-cities', [DropdownController::class, 'fetchCity']);