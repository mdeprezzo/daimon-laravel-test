<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Login\LoginRequest;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if (!Auth::attempt(credentials: $request->validated())) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = $request->user();

        return response()->json([
            'token' => $user->createToken('brewery-token')->plainTextToken
        ]);
    }
}
