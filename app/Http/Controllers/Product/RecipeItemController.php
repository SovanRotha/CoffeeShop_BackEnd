<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\RecipeItem;
use Illuminate\Http\Request;

class RecipeItemController extends Controller
{
    //
    public function index()
    {
        // Logic to retrieve recipe items
        $recipeItems = RecipeItem::all();
        return response()->json($recipeItems);
    }

    public function store(Request $request)
    {
        // Logic to create a new recipe item
        $validatedData = $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric',
            'unit' => 'required|string|max:255',
        ]);

        $recipeItem = RecipeItem::create($validatedData);

        return response()->json($recipeItem, 201);
    }

    public function show($id)
    {
        // Logic to retrieve a specific recipe item
        $recipeItem = RecipeItem::findOrFail($id);
        return response()->json($recipeItem);
    }

    public function update(Request $request, $id)
    {
        // Logic to update a specific recipe item
        $recipeItem = RecipeItem::findOrFail($id);

        $validatedData = $request->validate([
            'recipe_id' => 'sometimes|required|exists:recipes,id',
            'ingredient_id' => 'sometimes|required|exists:ingredients,id',
            'quantity' => 'sometimes|required|numeric',
            'unit' => 'sometimes|required|string|max:255',
        ]);

        $recipeItem->update($validatedData);

        return response()->json($recipeItem);
    }

    public function destroy($id)
    {
        // Logic to delete a specific recipe item
        $recipeItem = RecipeItem::findOrFail($id);
        $recipeItem->delete();

        return response()->json(['message' => 'Recipe item deleted successfully']);
    }
}
