<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\Purchase;
use App\Models\Purchase\Purchase_Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseItemController extends Controller
{
    //

    public function index()
    {
        $purchaseItem = Purchase_Item::with('purchase', 'ingredient')->latest()->paginate(10);

        return response()->json([
            "Message" => "Retreived All data",
            "purchaseItem" => $purchaseItem,
        ], 200);
    }

    public function show($id)
    {
        $purchaseItem = Purchase_Item::with([
            'purchase',
            'ingredient'
        ])->find($id);


        if (!$purchaseItem) {
            return response()->json([
                'message' =>
                'Purchase item not found',
            ], 404);
        }


        return response()->json([
            'message' =>
            'Purchase item retrieved successfully',

            'purchase_item' =>
            $purchaseItem,
        ], 200);
    }

    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            "purchase_id" => "required|exists:purchases, id",
            "ingredient_id" => "required|exists:ingredients, id",
            "quantity" => "required|numeric|min:0.01",
            "unit_price" => "required|numeric|min:0",
        ]);

        $purchase = Purchase::find($id);

        if (!$purchase) {
            return response()->json([
                "Message" => "Purchase Not found",
            ]);
        }

        if (in_array($purchase->status, ["RECEIVED", "CANCELLED"])) {
            return response()->json([
                "Message" => "Cannot add any Items in this purchase"
            ]);
        }

        $total_price = $validated['unit_price'] * $validated['quantity'];

        $purchaseItem = Purchase_Item::create([
            "purchase_id" => $validated["purchase_id"],
            "ingredient_id" => $validated["ingredient_id"],
            "quantity" => $validated["quantity"],
            "unit_price" => $validated["unit_price"],
            "total_price" => $total_price,
            "created_by" => Auth::id(),
        ]);

        $this->updatePurchaseTotal($purchase);

        return response()->json([
            "Message" => "Created Purhcase Items Successfully",
            "purchaseItem" => $purchaseItem->fresh(["purchase", "ingredient"])
        ], 201);
    }

    public function destroy($id)
    {
        $purchaseItem = Purchase_Item::find($id);

        if (
            $purchaseItem->purchase &&
            in_array(
                $purchaseItem->purchase->status,
                [
                    'RECEIVED',
                    'CANCELLED'
                ]
            )
        ) {

            return response()->json([
                'message' =>
                'This purchase item cannot be deleted',
            ], 422);
        }
        $purchase = $purchaseItem->purchase;

        $purchaseItem->delete();

        $this->updatePurchaseTotal($purchase);

        return response()->json([
            "Message" => "Item has deleted successfully"
        ]);
    }

    public function update(Request $request, $id)
    {
        $purchaseItem = Purchase_Item::with("purchase")->find($id);

        if (!$purchaseItem) {
            return response()->json([
                "Message" => "Purhcase Item not found"
            ]);
        }

        if (
            $purchaseItem->purchase &&
            in_array(
                $purchaseItem->purchase->status,
                [
                    'RECEIVED',
                    'CANCELLED'
                ]
            )
        ) {

            return response()->json([
                'message' =>
                'This purchase item cannot be updated',
            ], 422);
        }

        $validated = $request->validate([
            "ingredient_id" => "required|exists:ingredient_id",
            "quantity" => "required|numeric|min:0.01",
            "unit_price" => "required|numeric|min:0",
        ]);

        $total_price = $validated["unit_price"] * $validated["quantity"];

        $purchaseItem->update([
            'ingredient_id' =>
            $validated['ingredient_id'],

            'quantity' =>
            $validated['quantity'],

            'unit_price' =>
            $validated['unit_price'],

            'total_price' =>
            $total_price,
        ]);

        $this->updatePurchaseTotal($purchaseItem->purchase);


        return response()->json([
            "Message" => "Update Purchase Item Successfully",
            "purchaseItem" => $purchaseItem->fresh(["purchase", "ingredient"]),
        ]);
    }

    private function updatePurchaseTotal(Purchase $purchase)
    {
        $total = $purchase->purchaseItem()->sum('total_price');

        $purchase->update(['total_amount' => $total]);
    }
}
