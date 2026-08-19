<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Sale\Order_Item;
use App\Models\Sale\Order_Item_Modifier;
use Illuminate\Http\Request;

class OrderItemModifierController extends Controller
{
    //
    public function index()
    {
        $orderItemModifier = Order_Item_Modifier::with("orderItem", "option", "modifier")->get();

        return response()->json([
            "Message" => "Order Item Modifier retrieved successfully",
            "orderItemModifier" => $orderItemModifier,
        ], 200);
    }

    public function show($id)
    {
        $orderItemModifier = Order_Item_Modifier::with("orderItem", "option", "modifier")->find($id);

        return response()->json([
            "Message" => "Order Item Modifier retrieved successfully",
            "orderItemModifier" => $orderItemModifier,
        ], 200);
    }

    public function store(Request $request, $id)
    {
        $validate = $request->validate([
            "order_item_id" => "required|exists:order_items, id",
            "modifier_id" => "required|exists:modifiers, id",
            "modifier_option_id" => "required|exists:modifier_options, id",
            "quantity" => "required|numeric|min:0.01",
            "price_adjustment" => 'required|numeric|min:0'
        ]);

        $orderItem = Order_Item::find($id);

        if (!$orderItem) {
            return response()->json([
                'message' => 'Order item not found',
            ]);
        }

        $orderItemModifier = Order_Item_Modifier::create([
            "order_item_id" => $validate["order_item_id"],
            "modifier_id" => $validate["modifier_id"],
            "modifier_option_id" => $validate["modifier_option_id"],
            "quantity" => $validate["quantity"] ?? 1,
            "price_adjustment" => $validate["price_adjustment"],
        ]);

        return response()->json([
            'message' => 'Order item modifier created successfully',
            'orderItemModifier' =>
            $orderItemModifier->load(['orderItem', 'modifier', 'modifierOption']),
        ]);
    }

    public function update(Request $request, $id)
    {
        $orderItemModifier =
            Order_Item_Modifier::find($id);


        if (!$orderItemModifier) {
            return response()->json([
                'message' =>
                'Order item modifier not found',
            ], 404);
        }


        $validated = $request->validate([
            'modifier_id' => 'required|exists:modifiers,id',

            'modifier_option_id' => 'required|exists:modifier_options,id',

            'quantity' => 'nullable|numeric|min:0.01',

            'price_adjustment' => 'required|numeric',
        ]);


        $orderItemModifier->update([
            'modifier_id' => $validated['modifier_id'],

            'modifier_option_id' => $validated['modifier_option_id'],

            'quantity' => $validated['quantity'] ?? 1,

            'price_adjustment' => $validated['price_adjustment'],
        ]);


        return response()->json([
            'message' =>
            'Order item modifier updated successfully',

            'order_item_modifier' =>
            $orderItemModifier->fresh([
                'orderItem',
                'modifier',
                'modifierOption'
            ]),
        ], 200);
    }


    // Delete order item modifier
    public function destroy($id)
    {
        $orderItemModifier = Order_Item_Modifier::find($id);


        if (!$orderItemModifier) {
            return response()->json([
                'message' =>
                'Order item modifier not found',
            ], 404);
        }


        $orderItemModifier->delete();


        return response()->json([
            'message' =>
            'Order item modifier deleted successfully',
        ], 200);
    }
}
