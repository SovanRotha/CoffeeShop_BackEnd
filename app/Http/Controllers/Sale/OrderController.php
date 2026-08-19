<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Sale\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function index()
    {
        $order = Order::with('customer', 'user', 'orderItem', 'payment')->get();

        return response()->json([
            "Message" => "Retreived All Order successfully",
            "order" => $order,
        ], 200);
    }

    public function show($id)
    {
        $order = Order::with('customer', 'user', 'orderItem', 'payment')->find($id);

        return response()->json([
            "Message" => "Order retrieved successfully",
            "order" => $order,
        ], 200);
    }

    public function store(Request $request, $id)
    {
        $validate = $request->validate([
            "customer_id" => "nullalbe|exists:customers, id",
            "order_type" => "required|in:DINE_IN, TAKEAWAY, DELIVERY",
            'status' =>
            'nullable|in:PENDING,CONFIRMED,PREPARING,READY,SERVED,COMPLETED,CANCELLED',

            'discount' =>
            'nullable|numeric|min:0',

            'tax' =>
            'nullable|numeric|min:0',

            'note' =>
            'nullable|string',
        ]);

        $order = Order::create([
            "order_number" => "ORD" . now()->format("YmdHis"),
            "customer_id" => $validate["customer"],
            "user_id" => Auth::id(),
            "order_type" => $validate["order_type"],
            "status" => $validate["status"] ?? "PENDING",
            "subtotal" => 0,
            "discount" => $validate["discount"] ?? 0,
            "tax" => $validate["tax"] ?? 0,
            "total" => 0,
            "note" => $validate["note"],
        ]);

        return response()->json([
            "Message" => "Order created Successfully",
            "order" => $order,
        ], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                "Message" => "Order Not found!",
            ]);
        }

        $order->delete();

        return response()->json([
            "Message" => "Order has deleted Successfully",
        ]);
    }

    // Have not done Update because I need to finish recalculate the total price and call the function from Order Item Controller

    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                "Message" => "Order Not found!"
            ]);
        }
        $validate = $request->validate([
            "customer_id" => "nullalbe|exists:customers, id",
            "order_type" => "required|in:DINE_IN, TAKEAWAY, DELIVERY",
            'status' =>
            'nullable|in:PENDING,CONFIRMED,PREPARING,READY,SERVED,COMPLETED,CANCELLED',

            'discount' =>
            'nullable|numeric|min:0',

            'tax' =>
            'nullable|numeric|min:0',

            'note' =>
            'nullable|string',
        ]);

        $order->update([
            "customer_id" => $validate["customer_id"],
            "order_type" => $validate["order_type"],
            "status" => $validate["status"] ?? "PENDING",
            "discount" => $validate["discount"] ?? 0,
            "tax" => $validate["tax"] ?? 0,
            "note" => $validate["note"] ?? null, 
        ]);

        $subtotal = $order
            ->orderItems()
            ->sum('subtotal');

        $total = $subtotal - ($order->discount ?? 0) + ($order->tax ?? 0);

        $order->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);

        return response()->json([
            "Message" => "Order updated Successfully",
            "order" => $order
        ]);

    }
}
