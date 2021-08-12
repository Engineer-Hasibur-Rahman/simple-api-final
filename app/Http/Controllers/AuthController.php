<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    function Register(Request $request){
        $filds=$request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'password'=>"required|confirmed",
        ]);

        $user=User::create([
            'name'=>$filds['name'],
            'email'=>$filds['email'],
            'password'=>Hash::make($filds['password']),
        ]);
        
        //create token
        $token=$user->createToken('myAppToken')->plainTextToken;

        $response=[
            'user'=>$user,
            'token'=>$token,
        ];
        return response($response,201);
    }

    function Logout(Request $request){
        
        auth()->user()->tokens()->delete();
        return[
            'message'=>"Successfully Logout",
        ];
    }
    
    public function Login(Request $request){
        $filds=$request->validate([
            'email'=>'required|email',
            'password'=>"required",
        ]);
        // check email
        $user=User::where('email',$filds['email'])->first();
        //check email and password
        if(!$user || !Hash::check($filds['password'],$user->password)){
            return response([
                'message'=>'Bad Credential',
            ],401);
        }
        //create token
        $token=$user->createToken('myAppToken')->plainTextToken;

        $response=[
            'user'=>$user,
            'message'=>$token,
        ];
        return response($response,201);
    }
}
