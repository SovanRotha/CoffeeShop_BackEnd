<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    //
    public function index()
    {
        $ingredients = Ingredient::with('ingredientCategory')->get();
        return response()->json($ingredients);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingredient_category_id' => 'required|exists:ingredient_categories,id',
            'name' => 'required|string|max:255',
            'base_unit' => 'required|string|max:50',
            'current_stock' => 'nullable|numeric|min:0',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $ingredient = Ingredient::create($request->all());

        return response()->json($ingredient, 201);
    }

    public function show($id)
    {
        $ingredient = Ingredient::with('ingredientCategory')->findOrFail($id);
        return response()->json($ingredient);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ingredient_category_id' => 'required|exists:ingredient_categories,id',
            'name' => 'required|string|max:255',
            'base_unit' => 'required|string|max:50',
            'current_stock' => 'nullable|numeric|min:0',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $ingredient = Ingredient::findOrFail($id);
        $ingredient->update($request->all());

        return response()->json($ingredient);
    }

    public function destroy($id)
    {
        $ingredient = Ingredient::findOrFail($id);
        $ingredient->delete();

        return response()->json(null, 204);
    }

    
}
