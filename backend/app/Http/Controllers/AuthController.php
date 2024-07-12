<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Kreait\Firebase\Factory;

class AuthController extends Controller
{
    use HasApiTokens;
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|min:10|max:15|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone
        ]);

        $factory = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        $auth = $factory->createAuth();

        $auth->createUser([
            'uid' => $user->id,
            'email' => $user->email,
            'phoneNumber' => $user->phone,
            'password' => $request->password,
            'displayName' => $user->name,
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }
}
