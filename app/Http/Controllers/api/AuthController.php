<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function register (Request $request) {

    $data = $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|unique:users,email',
        'password' => 'required|string',
        'username' => 'required|string',
        'lastname'=> 'required|string'
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'username' => $data['username'],
        'lastname'=> $data['lastname'],
        'photo'=> 'default'
    ]);
 
        $token = $user->createToken('apiToken')->plainTextToken;
        
        $res = [
            'user' => $user,
            'token' => $token
        ];
        return response($res, 201);
    }

    public function login(Request $request) {
    
        if(!Auth::attempt($request->only('email','password'))){
            return response(401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];
        return response($res, 201);
    }

    public function user($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}