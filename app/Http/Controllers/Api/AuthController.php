<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        $validate = Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required',
        ]);
        if($validate->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'Validation failed',
                'errors'=>$validate->errors()
            ], 401);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Utilisateur créé',
            'access_token'=> $user->createToken('Token')->plainTextToken,
            'token_type' => 'Bearer'
        ], 200);
    }

    public function loginUser(Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'access_token'=> $user->createToken('Token')->plainTextToken,
                'token_type' => 'Bearer'
                ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json('Vous êtes déconnecté');
    }
}
