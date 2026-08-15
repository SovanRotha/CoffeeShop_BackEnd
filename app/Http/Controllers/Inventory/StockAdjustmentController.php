<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Ingredient;
use App\Models\Inventory\Stock_Log;
use App\Models\Inventory\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    //
    public function index()
    {
        $adjustments = StockAdjustment::with('ingredient', 'user')->latest()->paginate(20);    

        return response()->json($adjustments);
    }

    public function show($id)
    {
        $adjustment = StockAdjustment::with('ingredient', 'user')->findOrFail($id);

        return response()->json($adjustment);
    }

    public function destroy($id)
    {
        $adjustment = StockAdjustment::findOrFail($id);
        $adjustment->delete();

        return response()->json(['message' => 'Stock adjustment deleted successfully']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'type' => 'required|string|in:increase,decrease',
            'quantity' => 'required|numeric|min:0',
            'reason' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
            'note' => 'nullable|string',
        ]);

        try{

        return DB::transaction ( function () use ($request){
            
            $ingredient = Ingredient::lockForUpdate()->findOrFail($request['ingredient_id']);

            if($request['type'] === 'increase') {
                $newStock = $ingredient->current_stock + $request['quantity'];
            } else {
                $newStock = $ingredient->current_stock - $request['quantity'];
            }

            if($newStock < 0) {
                return response()->json(['message' => 'Insufficient stock for this adjustment'], 400);
            }

            $adjustment = StockAdjustment::create([
                'ingredient_id' => $request['ingredient_id'],
                'quantity' => $request['quantity'],
                'reason' => $request['reason'],
                'user_id' => Auth::id(),
                'note' => $request['note'],
            ]);

            $ingredient->update(['current_stock' => $newStock]);

            Stock_Log::create([
                'ingredient_id' => $request['ingredient_id'],
                'type' => 'adjustment',
                'quantity' => $request['quantity'],
                'reference_type' => StockAdjustment::class,
                'reference_id' => $adjustment->id,
                'user_id' => Auth::id(),
                'note' => $request['note'],
            ]);

            return response()->json(['message' => 'Stock adjustment created successfully', 'adjustment' => $adjustment], 201);


        });

        }catch (\Exception $e) {
            return response()->json(['message' => 'Error creating stock adjustment', 'error' => $e->getMessage()], 500);
        }

        return response()->json($adjustment, 201);
    }

    
}
