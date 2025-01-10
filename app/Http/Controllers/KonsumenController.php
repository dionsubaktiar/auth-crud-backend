<?php

namespace App\Http\Controllers;

use App\Models\konsumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KonsumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return konsumen::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function register(Request $request)
    {
        // Validate the input
        $request->validate([
            'username' => 'required|string|max:255|unique:konsumen,username',
            'email' => 'required|email|unique:konsumen,email',
            'password' => 'required|string|min:6|confirmed',
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tanggal_lahir' => 'required|date',
            'status_perkawinan' => 'required|string|max:50',
            'data_pasangan' => 'nullable|string|max:255',
        ]);

        // Create the new Konsumen record
        $konsumen = konsumen::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'status_perkawinan' => $request->status_perkawinan,
            'data_pasangan' => $request->data_pasangan,
        ]);

        // Create an API token for the user (for Laravel Passport or simple token-based auth)
        $token = $konsumen->createToken('API Token')->plainTextToken;

        // Return the response with the user details and token
        return response()->json([
            'konsumen' => $konsumen,
            'token' => $token
        ], 201);
    }

    // Login Function
    public function login(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find the user by email
        $konsumen = Konsumen::where('email', $request->email)->first();

        // Check if the user exists and the password matches
        if (!$konsumen || !Hash::check($request->password, $konsumen->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Generate an API token for the user
        $token = $konsumen->createToken('API Token')->plainTextToken;

        // Return the response with user details and token
        return response()->json([
            'konsumen' => $konsumen,
            'token' => $token
        ], 200);
    }

    // Get current authenticated user's details
    public function me(Request $request)
    {
        return response()->json(['konsumen' => $request->user()]);
    }

    // Logout Function
    public function logout(Request $request)
    {
        // Revoke the current access token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
