<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
      // Register a new user
      public function register(Request $request)
      {
          $request->validate([
              'name' => 'required',
              'email' => 'required|email|unique:users',
              'password' => 'required|min:6',
          ]);

          $user = User::create([
              'name' => $request->name,
              'email' => $request->email,
              'password' => Hash::make($request->password),
          ]);

          $token = JWTAuth::fromUser($user);

          return response()->json([
              'user' => $user,
              'token' => $token,
          ]);
      }

      // Login
      public function login(Request $request)
      {
          $credentials = $request->only('email', 'password');

          try {
              if (!$token = JWTAuth::attempt($credentials)) {
                  return response()->json(['error' => 'Invalid credentials'], 401);
              }
          } catch (JWTException $e) {
              return response()->json(['error' => 'Could not create token'], 500);
          }

          return response()->json(['token' => $token]);
      }

      // Get authenticated user
      public function me(Request $request)
      {
          return response()->json(auth()->user());
      }

      // Logout
      public function logout()
      {
          JWTAuth::invalidate(JWTAuth::getToken());
          return response()->json(['message' => 'Logged out successfully']);
      }

      // Refresh token
      public function refresh()
      {
          return response()->json([
              'token' => JWTAuth::refresh(JWTAuth::getToken())
          ]);
      }
}
