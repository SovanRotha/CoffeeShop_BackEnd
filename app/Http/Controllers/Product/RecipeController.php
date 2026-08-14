<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    //
    public function index()
    {
        $recipes = Recipe::with('recipeItem')->get();
        return response()->json($recipes);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $recipe = Recipe::create($validatedData);

        return response()->json($recipe, 201);
    }

    public function show($id)
    {
        $recipe = Recipe::with('recipeItem')->findOrFail($id);
        return response()->json($recipe);
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);

        $validatedData = $request->validate([
            'menu_item_id' => 'sometimes|required|exists:menu_items,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $recipe->update($validatedData);

        return response()->json($recipe);
    }

    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return response()->json(['message' => 'Recipe deleted successfully']);
    }
}
