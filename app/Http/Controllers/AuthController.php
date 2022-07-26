<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $attr = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone_no'=>'required|numeric'
        ]);
        if($attr->fails()){
            return $this->error('Bad request', 400,$attr->errors());
        }
        $attr=$attr->validated();
        $user = User::create([
            'name' => $attr['name'],
            'phone_no' => $attr['phone_no'],
            'password' => Hash::make($attr['password']),
            'email' => $attr['email']
        ]);
        $user->attachRole('user');
        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ],'User created Successfully',201);
    }

    public function login(Request $request)
    {
        $attr = Validator::make($request->all(),[
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);
        if($attr->fails()){
            return $this->error('Bad request', 400,$attr->errors());
        }
        $attr=$attr->validated();
        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'user'=>Auth::user()
        ],'User logged in Successfully');
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
