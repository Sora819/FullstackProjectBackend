<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();

            return response()->json([
                'token' => $user->createToken('api token')->plainTextToken,
                'name' => $user->name,
                'email' => $user->email
            ]);
        }

        return response('The provided credentials do not match our records', 404);
    }

    public function register(Request $request) {
        $credentials = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = new User();
        $user->fill(
            [
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => bcrypt($credentials['password'])
            ]
        );
        $user->save();

        return response()->json([
            'token' => $user->createToken('api token')->plainTextToken,
            'name' => $user->name,
            'email' => $user->email
        ]);
    }
}
