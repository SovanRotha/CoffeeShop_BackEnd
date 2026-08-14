<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\Config\Exception\ValidationException;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember' => 'nullable|boolean',
            ]);

            if (!Auth::guard('web')->attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ], $credentials['remember'] ?? false)) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            if ($user->status !== 'active') {

                Auth::guard('web')->logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return response()->json([
                    'message' => 'Your account is inactive.',
                ], 403);
            }

            $roles = $user->roles->pluck('name')->values();

            // Get permissions from roles
            $permissions = collect();

            foreach ($user->roles as $role) {
                $permissions = $permissions->merge(
                    $role->permissions->pluck('name')
                );
            }

            // Remove duplicate permissions
            $permissions = $permissions
                ->unique()
                ->values();

            return response()->json([
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'status' => $user->status,
                    'profile' => $user->profile,
                    'roles' => $roles,
                    'permissions' => $permissions,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
