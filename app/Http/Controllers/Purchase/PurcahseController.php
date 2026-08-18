<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\Purchase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurcahseController extends Controller
{
    //
    public function index()
    {
        $purchases = Purchase::with([
            'supplier',
            'purchaseItems.ingredient',
            'createdBy'
        ])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Retrieved purchases successfully',
            'purchases' => $purchases,
        ], 200);
    }

    public function show($id)
    {
        $purchase = Purchase::with([
            'supplier',
            'purchaseItems.ingredient',
            'createdBy'
        ])->find($id);

        if (!$purchase) {
            return response()->json([
                'message' => 'Purchase not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Purchase retrieved successfully',
            'purchase' => $purchase,
        ], 200);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',

            'invoice_number' =>
            'required|string|max:255|unique:purchases,invoice_number',

            'purchase_date' =>
            'required|date',

            'status' =>
            'required|in:DRAFT,ORDERED,PARTIALLY_RECEIVED,RECEIVED,CANCELLED',

            
        ]);

        $purchase = Purchase::create([
            'supplier_id' => $validated['supplier_id'],
            "invoice__number" => $validated['invoice_number'],
            "purchase_date" => $validated['purchase_date'],
            "total_amount" => 0,
            "status" => $validated['status'],
            "created_by" => Auth::id(),
        ]);

        return response()->json([
            "Message" => "Purchase has created successfully",
            "purchase" => $purchase,
        ], 201);
    }

    public function destroy($id)
    {
        $purchase = Purchase::find($id);

        if($purchase->status ==="RECEIVED"){
            return response()->json([
                "Message" => "Received purchase cannot be deleted",
            ]);
        }

        $purchase->delete();

        return response()->json([
            "Message" => "Purchase has deleted Successfully",
        ]);
    }

    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);

        if($purchase->status === "RECEIVED")
            {
                return response()->json([
                    "Message" => "Cannot updated!"
                ]);
            }

        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',

            'invoice_number' =>
            'required|string|max:255|unique:purchases,invoice_number'. $id,

            'purchase_date' =>
            'required|date',

            'status' =>
            'required|in:DRAFT,ORDERED,PARTIALLY_RECEIVED,RECEIVED,CANCELLED', 
        ]);

        $purchase->update([
            'supplier_id' =>
                $validated['supplier_id'],

            'invoice_number' =>
                $validated['invoice_number'],

            'purchase_date' =>
                $validated['purchase_date'],

            'status' =>
                $validated['status'],
        ]);

        return response()->json([
            "Message" => "Purchase has updated successfully",
            "purchase" => $purchase->fresh([

            ]),
        ]);
        
    }
}
