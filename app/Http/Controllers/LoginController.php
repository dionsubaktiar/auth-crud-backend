<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = Validator::make(
            $request->all(),
            [
                'email' => "required|email",
                "password" => "required"
            ]
        );
        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }

        if ($request->email == "admin@gmail.com" && $request->password == "admin123") {
            $verificationToken = base64_encode('verified_' . now());
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        return response()->json([
            'user' => $request->email,
            'token' => $verificationToken
        ], 200);
    }

    public function me(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'token' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json(['errors' => $validated->errors()], 422);
        }
        return response()->json([
            'message' => 'You are logged in',
            'user' => "admin@gmail.com",
        ], 200);
    }
}
