<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        try {


            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'phone' => 'nullable|string|max:20',
                'status' => 'nullable|string|in:active,inactive',
                'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'role' => 'required|string|exists:roles,name',
            ]);

            $profilePath = null;

            if ($request->hasFile('profile')) {
                $profilePath = $request->file('profile')->store('profiles', 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'phone' => $request->phone,
                'status' => $request->status,
                'profile' => $profilePath,
            ]);

            if ($request->role) {
                $user->assignRole($request->role);
            }

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'role' => $request->role,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function index()
    {
        $users = User::with('roles')->get();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if ($user->profile) {
            Storage::disk('public')
                ->delete($user->profile);
        }


        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|string|in:active,inactive',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|string|exists:roles,name',
        ]);

        $profilePath = $user->profile;

        if ($request->hasFile('profile')) {

            // Delete old profile
            if ($user->profile) {
                Storage::disk('public')
                    ->delete($user->profile);
            }

            // Store new profile
            $profilePath = $request
                ->file('profile')
                ->store('profiles', 'public');
        }

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'phone' => $request->phone ?? $user->phone,
            'status' => $request->status ?? $user->status,
            'profile' => $profilePath,
        ]);

        if ($request->has('role')) {
            $user->syncRoles($request->role);
        }

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }
}
