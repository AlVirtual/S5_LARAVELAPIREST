<?php

namespace App\Http\Controllers;

//use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $requestData['password'] = Hash::make($request->password);

        $user = User::create($requestData);

        $accessToken = $user->createToken('authToken')->accessToken;
        return response()->json(['user'=> $user,'access_token'=>$accessToken],200);

    }

    public function login(Request $request)
    {
        $loginData = $request->all();/* ->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]); */


        if(!Auth::attempt($loginData)){
            //return $loginData;
            return response()->json(['message' => 'Datos incorrectos'],400);
        }
        else{   
            /** @var \App\Models\User $user **/  
            $user = Auth::user(); 
            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json(['user'=> $user,'access_token'=>$accessToken],200);

        }
    }

    public function userInfo() 
    {
 
        $user = auth()->user();
      
        return response()->json(['user' => $user], 200);
 
    }


    

}
