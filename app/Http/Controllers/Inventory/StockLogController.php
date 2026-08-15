<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\Stock_Log;
use Illuminate\Http\Request;

class StockLogController extends Controller
{
    //
    
    public function index(Request $request)
    {
        $query = Stock_Log::with('ingredient', 'user')->get();

        if ($query->isEmpty()) {
            return response()->json(['message' => 'No stock logs found'], 404);
        }

        if($request->filled('ingredient_id')) {
            $query->where('ingredient_id', $request->input('ingredient_id'));
        }

        if($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }


        return response()->json($query);
    }

    public function show($id)
    {
        $log = Stock_Log::with('ingredient', 'user')->find($id);

        if (!$log) {
            return response()->json(['message' => 'Stock log not found'], 404);
        }

        return response()->json($log);
    }
}
