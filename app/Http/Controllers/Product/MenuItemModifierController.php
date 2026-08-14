<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Menu_Item_Modifier;
use Illuminate\Http\Request;

class MenuItemModifierController extends Controller
{
    //
    public function index()
    {
        $menuItemModifiers = Menu_Item_Modifier::with(['menuItem', 'modifier'])->get();
        return response()->json($menuItemModifiers);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'modifier_id' => 'required|exists:modifiers,id',
            'is_required' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $menuItemModifier = Menu_Item_Modifier::create($validatedData);

        return response()->json($menuItemModifier, 201);
    }

    public function show($id)
    {
        $menuItemModifier = Menu_Item_Modifier::with(['menuItem', 'modifier'])->findOrFail($id);
        return response()->json($menuItemModifier);
    }

    public function update(Request $request, $id)
    {
        $menuItemModifier = Menu_Item_Modifier::findOrFail($id);

        $validatedData = $request->validate([
            'menu_item_id' => 'sometimes|required|exists:menu_items,id',
            'modifier_id' => 'sometimes|required|exists:modifiers,id',
            'is_required' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $menuItemModifier->update($validatedData);

        return response()->json($menuItemModifier);
    }

    public function destroy($id)
    {
        $menuItemModifier = Menu_Item_Modifier::findOrFail($id);
        $menuItemModifier->delete();

        return response()->json(['message' => 'Menu item modifier deleted successfully']);
    }
}
