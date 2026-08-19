<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Sale\Order;
use App\Models\Sale\Order_Item;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    //
    public function index()
    {
        $orderItem = Order_Item::with("order", "menuItem", "orderItemModifier")->get();

        return response()->json([
            "Message" => "Order Item retreived Successfully",
            "orderItem" => $orderItem, 
        ], 200);
    }

    public function show($id)
    {

        $orderItem = Order_Item::with("order", "menuItem", "orderItemModifier")->find($id);

        return response()->json([
            "Message" => "Order Item Retreived Successfully",
            "orderItem" => $orderItem,
        ],200);
    }

    public function store(Request $request, $id)
    {   
        $validate = $request->validate([
            "order_id" => "required|exists:orders,id",
            "menu_item_id" => "required|exists:menu_items, id",
            "quantity" => "required|numeric|min:0.01",
            "unit_price" => "required|numeric|min:0",
            "discount" => "required|numeric|min:0",
            "note" => "nullalbe",
        ]);

        $order = Order::find($id);

        if(!$order){
            return response()->json([
                "Message" => "Order not Found!"
            ]);
        }

        $discount = $validate["discount"] ?? 0;

        $subtotal = $validate["quantity"]  *  ( $validate["unit_price"] - $validate["discount"] ) ;

        $orderItem = Order_Item::create([
            "order_id" => $validate["order_id"],
            "menu_item_id" => $validate["menu_item_id"],
            "quantity" => $validate["quantity"],
            "discount" => $discount,
            "subtotal" => $subtotal,
            "note" => $validate["note"]
        ]);

        $this->recalculateOrder($order);

        return response()->json([
            "Message" => "Order Item created Successfully",
            "orderItem" => $orderItem->load([
                "order", "menuItem", "orderItemModifier"
            ]),
        ]);

    }

    public function destroy($id)
    {
        $orderItem = Order_Item::with("order")->find($id);

        $order = $orderItem->order;


        $orderItem->delete();

        // callback function recalculateTotal
        $this->recalculateOrder($order);

        return response()->json([
            "Message" => "Order Item has deleted Successfully"
        ]);
    }

    public function update(Request $request, $id)
    {

        $orderItem = Order_Item::find($id);

        if(!$orderItem)
            {
                return response()->json([
                    "Message" => "Order Item Not found!"
                ]);
            }

        $validate = $request->validate([

            "menu_item_id" => "required|exists:menu_items, id",
            "quantity" => "required|numeric|min:0.01",
            "unit_price" => "required|numeric|min:0",
            "discount" => "required|numeric|min:0",
            "note" => "nullalbe",
        ]);
        
        $discount = $validate["discount"] ?? 0;

        $subtotal = $validate["quantity"]  *  ( $validate["unit_price"] - $validate["discount"] ) ;

        $orderItem->update([
            "menu_item_id" => $validate["menu_item_id"],
            "quantity" => $validate["quantity"],
            "unit_price" => $validate["unit_price"],
            "discount" => $discount,
            "subtotal" => $subtotal,
            "note" => $validate["note"],
        ]);

        $this->recalculateOrder($orderItem->order);

        return response()->json([
            "Message" => "Order Item has updated Successfully",
            "orderItem" => $orderItem
        ]);

    

    }

    private function recalculateOrder(Order $order)
    {
        $subtotal = $order->orderItem()->sum("subtotal");

        $total = $subtotal - $order->discount + $order->tax;

        return response()->json([
            'subtotal' => $subtotal,

            'total' => $total,
        ]);
    }
    
}


