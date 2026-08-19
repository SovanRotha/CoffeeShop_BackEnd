<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Models\Sale\Order;
use App\Models\Sale\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
    public function index()
    {
        $payment = Payment::with('order')->get();

        return response()->json([
            "Message" => "Retrieved Payments",
            "payment" => $payment,
        ],200);
    }

    public function store(Request $request, $id)
    {
        $validate = $request->validate([
            "order_id" => "required|exists:orders, id",
            "method" => "required|in:KHQR, CARD, CASH",
            "status" => "required|in:PENDING, PAID, FAILED",
            "transaction_reference" => "nullable|string",
            "paid_at" => "nullalbe",
        ]);

        $order = Order::find($validate["order_id"]);

        if(!$order)
            {
                return response()->json([
                    "Message" => "Order Not Found !"
                ]);
            }

        $amount = $order->total;

        $payment = Payment::create([
            "order_id" => $validate["order_id"],
            "method" => $validate["method"],
            "amount" => $amount,
            "status" => $validate["status"],
            "transaction_reference" => $validate["transaction_reference"] ?? null,
            "paid_at" => $validate["paid_at"] ?? null,
        ]);

        if($payment->status === "PAID"){
            $order->update([
                "status" => "COMPLETE"
            ]);
        }

        return response()->json([
            "Message" => "Payment Successfully",
            "payment" => $payment,
        ]);
        
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);

        $payment->delete();

        return response()->json([
            "Message" => "payment deleted successfully"
        ]);
    }

    public function show($id)
    {
        $payment = Payment::with("order")->find($id);

        if(!$payment){
            return response()->json([
                "Payment not found !"
            ]);
        }

        return response()->json([
            "Message" => "Rertreived Payment",
            "payment" => $payment
        ]);

    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        $validate = $request->validate([    
            "method" => "required|in:KHQR, CARD, CASH",
            "status" => "required|in:PENDING, PAID, FAILED",
            "transaction_reference" => "nullable|string",
            "paid_at" => "nullalbe",
        ]);

        $order = Order::find($validate["order_id"]);

        if(!$order)
            {
                return response()->json([
                    "Message" => "Order Not Found !"
                ]);
            }

        $amount = $order->total;

        $payment->update([
            "method" => $validate["method"],
            "amount" => $amount,
            "status" => $validate["status"],
            "transaction_reference" => $validate["transaction_reference"] ?? null,
            "paid_at" => $validate["paid_at"] ?? null,
        ]);

        if($payment->status === "PENDING")
            {
                $order->update([
                    "status" => "COMPLETE"
                ]);
            }
        
        return response()->json([
            "Message" => "Payment Updated Successfully",
            "payment" => $payment
        ]);
        
    }

    
}
