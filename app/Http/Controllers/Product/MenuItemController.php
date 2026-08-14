<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Menu_Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    //
    public function index()
    {
        $menuItems = Menu_Item::with('category')->get();
        return response()->json($menuItems);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:active,inactive',
            'is_available' => 'nullable|boolean',
        ]);

        $imagePath = null;

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu_items', 'public');
            $validatedData['image'] = $imagePath;
        }

        $menuItem = Menu_Item::create($validatedData);

        return response()->json($menuItem, 201);
    }

    public function show($id)
    {
        $menuItem = Menu_Item::with('category')->findOrFail($id);
        return response()->json($menuItem);
    }

    public function update(Request $request, $id)
    {
        $menuItem = Menu_Item::findOrFail($id);

        $validatedData = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'sometimes|required|numeric|min:0',
            'status' => 'nullable|string|in:active,inactive',
            'is_available' => 'nullable|boolean',
        ]);

        if($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($menuItem->image) {
                Storage::disk('public')->delete($menuItem->image);
            }
            $imagePath = $request->file('image')->store('menu_items', 'public');
            $validatedData['image'] = $imagePath;
        }

        $menuItem->update($validatedData);

        return response()->json($menuItem);
    }

    public function destroy($id)
    {
        $menuItem = Menu_Item::findOrFail($id);

        // Delete the image if it exists
        if ($menuItem->image) {
            Storage::disk('public')->delete($menuItem->image);
        }

        $menuItem->delete();

        return response()->json(['message' => 'Menu item deleted successfully']);
    }
}
