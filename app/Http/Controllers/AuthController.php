<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        //obter nosso email e senha
        $token = auth('api')->attempt($request->all(['email','password'], 200));

        //retornar um JWT
        if($token){ //sucesso na autentificação
            return response()->json(['token' => $token]);
        } else { // erro de email ou senha
            return response()->json(['erro' => 'Usuario ou senha invalidos!'], 403);
        }

        return 'login';
    }

    public function logout()
    {
        return 'logout';
    }

    public function refresh()
    {
        return 'refresh';
    }


    public function me()
    {
        return 'me';
    }

}
