<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        // Autentica um usuário fixo para testes
        if (app()->environment('local')) {
            $testUser = User::firstOrCreate(
                ['email' => 'cesar2@gmail.com'],
                ['name' => 'Cesar', 'password' => bcrypt('12345678')]
            );
            Auth::login($testUser);
        }
    }
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'token' => "Bearer $token"
        ], 201);
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 400);
        }

        $user = Auth::user();

        $cacheKey = 'user_' . $user->id;
        $cachedData = Cache::get($cacheKey);

        if (!$cachedData) {
            $token = $user->createToken('authToken')->plainTextToken;
            $cachedData = [
                'id' => $user->id,
                'name' => $user->name,
                'token' => "Bearer $token",
            ];

            Cache::put($cacheKey, $cachedData, now()->addMinutes(60));
        }

        return response()->json([$cachedData], 200);
    }
    public function logout(Request $request)
    {
        $cacheKey = 'user_' . $request->user()->id;
        Cache::forget($cacheKey);

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
