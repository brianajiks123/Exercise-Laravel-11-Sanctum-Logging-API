<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $creds = $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required|min:8"
        ]);

        if (!auth()->attempt($creds)) {
            return response()->json([
                "message" => "Invalid credentials"
            ], 401);
        }

        $user = auth()->user();

        return response()->json([
            "token" => $user->createToken("api_todo_token")->plainTextToken
        ], 200);
    }
}
