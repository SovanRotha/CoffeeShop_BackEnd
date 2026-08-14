<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Modifier;
use Illuminate\Http\Request;

class ModifierController extends Controller
{
    //
    public function index()
    {
        $modifiers = Modifier::with('option')->get();
        return response()->json($modifiers);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $modifier = Modifier::create($validatedData);

        return response()->json($modifier, 201);
    }

    public function show($id)
    {
        $modifier = Modifier::with('option')->findOrFail($id);
        return response()->json($modifier);
    }

    public function update(Request $request, $id)
    {
        $modifier = Modifier::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        $modifier->update($validatedData);

        return response()->json($modifier);
    }

    public function destroy($id)
    {
        $modifier = Modifier::findOrFail($id);
        $modifier->delete();

        return response()->json(['message' => 'Modifier deleted successfully']);
    }
}
