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
        return response()->json(['user' => $user, 'access_token' => $accessToken], 200);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);


        if (!Auth::attempt($loginData)) {

            return response()->json(['Atenció' => 'Dades incorrectes'], 400);
        } else {
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json(['Has accedit a l\'aplicació' => $user, 'access_token' => $accessToken], 200);
        }
    }

    public function userInfo()
    {

        $user = Auth::user();
        return response()->json(['Usuari' => $user], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['Missatge' => 'Sessió tancada amb èxit'], 200);
    }
}
