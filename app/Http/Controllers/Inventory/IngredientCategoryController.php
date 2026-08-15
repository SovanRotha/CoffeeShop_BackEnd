<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Ingredient_Category;
use Illuminate\Http\Request;

class IngredientCategoryController extends Controller
{
    //
    public function index()
    {
        $ingredientCategories = Ingredient_Category::all();
        return response()->json($ingredientCategories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $ingredientCategory = Ingredient_Category::create($request->all());

        return response()->json($ingredientCategory, 201);
    }

    public function show($id)
    {
        $ingredientCategory = Ingredient_Category::findOrFail($id);
        return response()->json($ingredientCategory);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $ingredientCategory = Ingredient_Category::findOrFail($id);
        $ingredientCategory->update($request->all());

        return response()->json($ingredientCategory);
    }

    public function destroy($id)
    {
        $ingredientCategory = Ingredient_Category::findOrFail($id);
        $ingredientCategory->delete();

        return response()->json(null, 204);
    }
}
