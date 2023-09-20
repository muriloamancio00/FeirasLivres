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
        auth('api')->logout();
        return response()->json(['msg' => 'Logout Realizado com sucesso!']);
    }

    public function refresh()
    {
        //para renovar o token precisamos do token valido no momento
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }


    public function me()
    {
      return response()->json(auth()->user());
    }

}
