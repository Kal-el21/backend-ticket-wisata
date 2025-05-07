<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ]);

        // untuk mencari user
        $user = User::where('email', $request->email)->first();

        // untuk mengecek apakah ada user dengan passwordnya
        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => ['Invalid credentials.']
            ], 401);
        }

        return response()->json([
            'token' => $user->createToken($request->email)->plainTextToken,
            'user' => $user
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => ['You have been logged out.']
        ]);
    }

    public function category(Request $request) {
        $categories = Category::when($request->keyword, function ($query) use ($request) {
            $query->where('name', 'like', "%{$request->keyword}%")
                ->orWhere('description', 'like', "%{$request->keyword}%");
        })->orderBy('id', 'desc')->paginate(10);
        return response()->json([
            'status' => 'berhasill',
            'message' => $categories
        ], 200);
    }
}

