<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Ingredient;
use App\Models\Inventory\Stock_Log;
use App\Models\Inventory\Waste_Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WasteRecordController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Waste_Record::with('ingredient', 'user');

        if ($request->filled('ingredient_id')) {
            $query->where('ingredient_id', $request->input('ingredient_id'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->input('start_date'), $request->input('end_date')]);
        }

        $wasteRecords = $query->get();

        return response()->json($wasteRecords);
    }

    public function show($id)
    {
        $wasteRecord = Waste_Record::with('ingredient', 'user')->find($id);

        if (!$wasteRecord) {
            return response()->json(['message' => 'Waste record not found'], 404);
        }

        return response()->json($wasteRecord);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:ingredients,id',
            'quantity' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'note' => 'nullable|string',
        ]);

        try {

            return DB::transaction(function () use ($request) {

            // Check if the ingredient exists and has enough stock
                $ingredient = Ingredient::findOrFail($request->ingredient_id);

            // Check if the ingredient has enough stock
                if ($ingredient->current_stock < $request->quantity) {
                    return response()->json(['message' => 'Insufficient stock for this ingredient'], 400);
                }

            // Create the waste record and update the stock
                $wasteRecord = Waste_Record::create([
                    'ingredient_id' => $request->ingredient_id,
                    'quantity' => $request->quantity,
                    'reason' => $request->reason,
                    'user_id' => Auth::id(),
                    'note' => $request->note,
                ]);
            // Decrement the current stock of the ingredient
                $ingredient->decrement('current_stock', $request->quantity);

            // Create a stock log entry for this waste record
                Stock_Log::create([
                    'ingredient_id' => $request->ingredient_id,
                    'quantity' => $request->quantity,
                    'type' => 'waste',
                    'user_id' => Auth::id(),
                    'note' => $request->note,
                ]);

                return response()->json(
                    [
                        'message' => 'Waste record created successfully',
                        'data' => [
                            'waste_record' => $wasteRecord,
                            'current_stock' => $ingredient->current_stock
                        ]
                    ]
                );
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating waste record', 'error' => $e->getMessage()], 500);
        }

        return response()->json($wasteRecord, 201);
    }
}
