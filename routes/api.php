<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Inventory\IngredientCategoryController;
use App\Http\Controllers\Inventory\IngredientController;
use App\Http\Controllers\Inventory\StockAdjustmentController;
use App\Http\Controllers\Inventory\StockLogController;
use App\Http\Controllers\Inventory\WasteRecordController;
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

    Route::middleware('menu_items.view')->get('/menu-items', [MenuItemController::class, 'index']);
    Route::middleware('menu_items.create')->post('/menu-items', [MenuItemController::class, 'store']);
    Route::middleware('menu_items.view')->get('/menu-items/{id}', [MenuItemController::class, 'show']);
    Route::middleware('menu_items.update')->put('/menu-items/{id}', [MenuItemController::class, 'update']);
    Route::middleware('menu_items.update')->patch('/menu-items/{id}', [MenuItemController::class, 'update']);
    Route::middleware('menu_items.delete')->delete('/menu-items/{id}', [MenuItemController::class, 'destroy']);

    Route::middleware('menu_item-modifiers.view')->get('/menu-item-modifiers', [MenuItemModifierController::class, 'index']);
    Route::middleware('menu_item-modifiers.create')->post('/menu-item-modifiers', [MenuItemModifierController::class, 'store']);
    Route::middleware('menu_item-modifiers.view')->get('/menu-item-modifiers/{id}', [MenuItemModifierController::class, 'show']);
    Route::middleware('menu_item-modifiers.update')->put('/menu-item-modifiers/{id}', [MenuItemModifierController::class, 'update']);
    Route::middleware('menu_item-modifiers.update')->patch('/menu-item-modifiers/{id}', [MenuItemModifierController::class, 'update']);
    Route::middleware('menu_item-modifiers.delete')->delete('/menu-item-modifiers/{id}', [MenuItemModifierController::class, 'destroy']);

    Route::middleware('modifiers.view')->get('/modifiers', [ModifierController::class, 'index']);
    Route::middleware('modifiers.create')->post('/modifiers', [ModifierController::class, 'store']);
    Route::middleware('modifiers.view')->get('/modifiers/{id}', [ModifierController::class, 'show']);
    Route::middleware('modifiers.update')->put('/modifiers/{id}', [ModifierController::class, 'update']);
    Route::middleware('modifiers.update')->patch('/modifiers/{id}', [ModifierController::class, 'update']);
    Route::middleware('modifiers.delete')->delete('/modifiers/{id}', [ModifierController::class, 'destroy']);

    Route::middleware('modifier_options.view')->get('/modifier-options', [ModifierOptionController::class, 'index']);
    Route::middleware('modifier_options.create')->post('/modifier-options', [ModifierOptionController::class, 'store']);
    Route::middleware('modifier_options.view')->get('/modifier-options/{id}', [ModifierOptionController::class, 'show']);
    Route::middleware('modifier_options.update')->put('/modifier-options/{id}', [ModifierOptionController::class, 'update']);
    Route::middleware('modifier_options.update')->patch('/modifier-options/{id}', [ModifierOptionController::class, 'update']);
    Route::middleware('modifier_options.delete')->delete('/modifier-options/{id}', [ModifierOptionController::class, 'destroy']);

    Route::middleware('recipes.view')->get('/recipes', [RecipeController::class, 'index']);
    Route::middleware('recipes.create')->post('/recipes', [RecipeController::class, 'store']);
    Route::middleware('recipes.view')->get('/recipes/{id}', [RecipeController::class, 'show']);
    Route::middleware('recipes.update')->put('/recipes/{id}', [RecipeController::class, 'update']);
    Route::middleware('recipes.delete')->delete('/recipes/{id}', [RecipeController::class, 'destroy']);

    Route::middleware('recipe_items.view')->get('/recipe-items', [RecipeItemController::class, 'index']);
    Route::middleware('recipe_items.create')->post('/recipe-items', [RecipeItemController::class, 'store']);
    Route::middleware('recipe_items.view')->get('/recipe-items/{id}', [RecipeItemController::class, 'show']);
    Route::middleware('recipe_items.update')->put('/recipe-items/{id}', [RecipeItemController::class, 'update']);
    Route::middleware('recipe_items.delete')->delete('/recipe-items/{id}', [RecipeItemController::class, 'destroy']);

    Route::middleware('ingredient_categories.view')->get('/ingredient-categories', [IngredientCategoryController::class, 'index']);
    Route::middleware('ingredient_categories.view')->get('/ingredient-categories/{id}', [IngredientCategoryController::class, 'show']);
    Route::middleware('ingredient_categories.delete')->delete('/ingredient-categories/{id}', [IngredientCategoryController::class, 'destroy']);
    Route::middleware('ingredient_categories.update')->put('/ingredient-categories/{id}', [IngredientCategoryController::class, 'update']);
    Route::middleware('ingredient_categories.create')->post('/ingredient-categories', [IngredientCategoryController::class, 'store']);

    Route::middleware('ingredients.view')->get('/ingredients', [IngredientController::class, 'index']);
    Route::middleware('ingredients.view')->get('/ingredients/{id}', [IngredientController::class, 'show']);
    Route::middleware('ingredients.create')->post('/ingredients', [IngredientController::class, 'store']);
    Route::middleware('ingredients.update')->put('/ingredients/{id}', [IngredientController::class, 'update']);
    Route::middleware('ingredients.delete')->delete('/ingredients', [IngredientController::class, 'destroy']);

    Route::middleware('stock_logs.view')->get('/stock-logs', [StockLogController::class, 'index']);
    Route::middleware('stock_logs.view')->get('/stock-logs/{id}', [StockLogController::class, 'show']);

    Route::middleware('stock_adjustments.view')->get('/stock-adjustments', [StockAdjustmentController::class, 'index']);
    Route::middleware('stock_adjustments.view')->get('/stock-adjustments/{id}', [StockAdjustmentController::class, 'show']);
    Route::middleware('stock_adjustments.delete')->delete('/stock-adjustments/{id}', [StockAdjustmentController::class, 'destroy']);
    Route::middleware('stock_adjustments.update')->put('/stock-adjustments/{id}', [StockAdjustmentController::class, 'update']);
    Route::middleware('stock_adjustments.create')->post('/stock-adjustments/{id}', [StockAdjustmentController::class, 'store']);

    Route::middleware('waste_records.view')->get('/waste-records', [WasteRecordController::class, 'index']);
    Route::middleware('waste_records.view')->get('/waste-records/{id}', [WasteRecordController::class, 'show']);
    Route::middleware('waste_records.create')->post('/waste-records', [WasteRecordController::class, 'store']);
    Route::middleware('waste_records.update')->put('/waste-records/{id}', [WasteRecordController::class, 'update']);
    Route::middleware('waste_records.delete')->delete('/waste-records/{id}', [WasteRecordController::class, 'destroy']);

    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/logout', [LogoutController::class, 'logout']);
});
