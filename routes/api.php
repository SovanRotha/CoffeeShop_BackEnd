<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\MenuItemController;
use App\Http\Controllers\Product\MenuItemModifierController;
use App\Http\Controllers\Product\ModifierController;
use App\Http\Controllers\Product\ModifierOptionController;
use App\Http\Controllers\Product\RecipeController;
use App\Http\Controllers\Product\RecipeItemController;
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



Route::middleware('web')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    
    Route::middleware('users.view')->get('/users', [RegisterController::class, 'index']);
    Route::middleware('users.create')->post('/register', [RegisterController::class, 'register']);
    Route::middleware('users.delete')->delete('/users/{id}', [RegisterController::class, 'destroy']);
    Route::middleware('users.update')->put('/users/{id}', [RegisterController::class, 'update']);
    Route::middleware('users.update')->patch('/users/{id}', [RegisterController::class, 'update']);
    Route::middleware('users.view')->get('/users/{id}', [RegisterController::class, 'show']);
    Route::middleware('users.update')->post('/users/{id}/assign-role', [RegisterController::class, 'assignRole']);

    Route::middleware('categories.view')->get('/categories', [CategoryController::class, 'index']);
    Route::middleware('categories.create')->post('/categories', [CategoryController::class, 'store']);
    Route::middleware('categories.view')->get('/categories/{id}', [CategoryController::class, 'show']);
    Route::middleware('categories.update')->put('/categories/{id}', [CategoryController::class, 'update']);
    Route::middleware('categories.update')->patch('/categories/{id}', [CategoryController::class, 'update']);
    Route::middleware('categories.delete')->delete('/categories/{id}', [CategoryController::class, 'destroy']);
    
    Route::middleware('menu-items.view')->get('/menu-items', [MenuItemController::class, 'index']);
    Route::middleware('menu-items.create')->post('/menu-items', [MenuItemController::class, 'store']);
    Route::middleware('menu-items.view')->get('/menu-items/{id}', [MenuItemController::class, 'show']);
    Route::middleware('menu-items.update')->put('/menu-items/{id}', [MenuItemController::class, 'update']); 
    Route::middleware('menu-items.update')->patch('/menu-items/{id}', [MenuItemController::class, 'update']);
    Route::middleware('menu-items.delete')->delete('/menu-items/{id}', [MenuItemController::class, 'destroy']);

    Route::middleware('menu-item-modifiers.view')->get('/menu-item-modifiers', [MenuItemModifierController::class, 'index']);
    Route::middleware('menu-item-modifiers.create')->post('/menu-item-modifiers', [MenuItemModifierController::class, 'store']);
    Route::middleware('menu-item-modifiers.view')->get('/menu-item-modifiers/{id}', [MenuItemModifierController::class, 'show']);
    Route::middleware('menu-item-modifiers.update')->put('/menu-item-modifiers/{id}', [MenuItemModifierController::class, 'update']); 
    Route::middleware('menu-item-modifiers.update')->patch('/menu-item-modifiers/{id}', [MenuItemModifierController::class, 'update']);
    Route::middleware('menu-item-modifiers.delete')->delete('/menu-item-modifiers/{id}', [MenuItemModifierController::class, 'destroy']);

    Route::middleware('modifiers.view')->get('/modifiers', [ModifierController::class, 'index']);
    Route::middleware('modifiers.create')->post('/modifiers', [ModifierController::class, 'store']);
    Route::middleware('modifiers.view')->get('/modifiers/{id}', [ModifierController::class, 'show']);
    Route::middleware('modifiers.update')->put('/modifiers/{id}', [ModifierController::class, 'update']); 
    Route::middleware('modifiers.update')->patch('/modifiers/{id}', [ModifierController::class, 'update']);
    Route::middleware('modifiers.delete')->delete('/modifiers/{id}', [ModifierController::class, 'destroy']);

    Route::middleware('modifier-options.view')->get('/modifier-options', [ModifierOptionController::class, 'index']);
    Route::middleware('modifier-options.create')->post('/modifier-options', [ModifierOptionController::class, 'store']);
    Route::middleware('modifier-options.view')->get('/modifier-options/{id}', [ModifierOptionController::class, 'show']);
    Route::middleware('modifier-options.update')->put('/modifier-options/{id}', [ModifierOptionController::class, 'update']); 
    Route::middleware('modifier-options.update')->patch('/modifier-options/{id}', [ModifierOptionController::class, 'update']);
    Route::middleware('modifier-options.delete')->delete('/modifier-options/{id}', [ModifierOptionController::class, 'destroy']);

    Route::middleware('recipes.view')->get('/recipes', [RecipeController::class, 'index']);
    Route::middleware('recipes.create')->post('/recipes', [RecipeController::class, 'store']);
    Route::middleware('recipes.view')->get('/recipes/{id}', [RecipeController::class, 'show']);
    Route::middleware('recipes.update')->put('/recipes/{id}', [RecipeController::class, 'update']);
    Route::middleware('recipes.delete')->delete('/recipes/{id}', [RecipeController::class, 'destroy']);

    Route::middleware('recipe-items.view')->get('/recipe-items', [RecipeItemController::class, 'index']);
    Route::middleware('recipe-items.create')->post('/recipe-items', [RecipeItemController::class, 'store']);
    Route::middleware('recipe-items.view')->get('/recipe-items/{id}', [RecipeItemController::class, 'show']);
    Route::middleware('recipe-items.update')->put('/recipe-items/{id}', [RecipeItemController::class, 'update']);
    Route::middleware('recipe-items.delete')->delete('/recipe-items/{id}', [RecipeItemController::class, 'destroy']);   

    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/logout', [LogoutController::class, 'logout']);
});
