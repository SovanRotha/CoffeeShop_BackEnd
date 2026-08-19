<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sale\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Get all customers
     */
    public function index()
    {
        $customers = Customer::latest()->get();

        return response()->json([
            'message' => 'Customers retrieved successfully',
            'customers' => $customers,
        ], 200);
    }


    /**
     * Create customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>
                'required|string|max:255',

            'phone' =>
                'nullable|string|max:50',

            'email' =>
                'nullable|email|max:255',

            'loyalty_points' =>
                'nullable|integer|min:0',

            'status' =>
                'required|in:ACTIVE,INACTIVE',
        ]);


        $customer = Customer::create([
            'name' =>
                $validated['name'],

            'phone' =>
                $validated['phone'] ?? null,

            'email' =>
                $validated['email'] ?? null,

            'loyalty_points' =>
                $validated['loyalty_points'] ?? 0,

            'status' =>
                $validated['status'],
        ]);


        return response()->json([
            'message' => 'Customer created successfully',
            'customer' => $customer,
        ], 201);
    }


    /**
     * Get one customer
     */
    public function show($id)
    {
        $customer = Customer::find($id);


        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }


        return response()->json([
            'message' => 'Customer retrieved successfully',
            'customer' => $customer,
        ], 200);
    }


    /**
     * Update customer
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);


        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }


        $validated = $request->validate([
            'name' =>
                'required|string|max:255',

            'phone' =>
                'nullable|string|max:50',

            'email' =>
                'nullable|email|max:255',

            'loyalty_points' =>
                'nullable|integer|min:0',

            'status' =>
                'required|in:ACTIVE,INACTIVE',
        ]);


        $customer->update($validated);


        return response()->json([
            'message' => 'Customer updated successfully',
            'customer' => $customer,
        ], 200);
    }


    /**
     * Delete customer
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);


        if (!$customer) {
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }


        $customer->delete();


        return response()->json([
            'message' => 'Customer deleted successfully',
        ], 200);
    }
}