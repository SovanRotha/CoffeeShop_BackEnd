<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Modifier_Option;
use Illuminate\Http\Request;

class ModifierOptionController extends Controller
{
    //
    public function index()
    {
        $modifierOptions = Modifier_Option::with('modifier')->get();
        return response()->json($modifierOptions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'modifier_id' => 'required|exists:modifiers,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $modifierOption = Modifier_Option::create($validatedData);

        return response()->json($modifierOption, 201);
    }

    public function show($id)
    {
        $modifierOption = Modifier_Option::with('modifier')->findOrFail($id);
        return response()->json($modifierOption);
    }

    public function update(Request $request, $id)
    {
        $modifierOption = Modifier_Option::findOrFail($id);

        $validatedData = $request->validate([
            'modifier_id' => 'sometimes|required|exists:modifiers,id',
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $modifierOption->update($validatedData);

        return response()->json($modifierOption);
    }

    public function destroy($id)
    {
        $modifierOption = Modifier_Option::findOrFail($id);
        $modifierOption->delete();

        return response()->json(['message' => 'Modifier option deleted successfully']);
    }
}
