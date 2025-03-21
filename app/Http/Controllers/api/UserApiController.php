<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function login(Request $request)
    {           
        $validated = [
            'email' => 'required',
            'password' => 'required|string'
        ];

        $request->validate($validated);
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['user' => $user, 'token' => $token];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Invalid email or password'];
        return response()->json($response, 400);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'phone' => 'required',
                'password' => 'required'
            ]);

            $user = User::create($validated);

            return response()->json($user, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->validator->errors()->first('email')
            ], 422);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $id = $request->query('id');
        $users = User::find($id);
        if (!$users) {
            return response()->json(['message' => 'User  not found'], 404);
        }
        return response()->json($users, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $users = User::find($id);
        if (!$users) {
            return response()->json(['message' => 'User  not found'], 404);
        }
        $users->update($request->all());
        return response()->json($users, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::find($id);
        if (!$users) {
            return response()->json(['message' => 'users not found'], 404);
        }
        $users->delete();
        return response()->json(['message' => 'users deleted'], 200);
    }
}
