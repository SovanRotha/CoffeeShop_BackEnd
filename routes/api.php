<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::put('/users/{id}', [RegisterController::class, 'update']);
Route::delete('/users/{id}', [RegisterController::class, 'destroy']);
Route::get('/users', [RegisterController::class, 'index']);
Route::get('/users/{id}', [RegisterController::class, 'show']);

Route::post('/register', [RegisterController::class, 'register']);
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LogoutController::class, 'logout']);

Route::middleware('web')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
});


