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

    public function updateProfile(Request $request)
    {
        $user = auth()->user(); // Obtém o usuário autenticado

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return response()->json(['message' => 'Perfil atualizado com sucesso', 'user' => $user]);
    }

    public function me()
    {
      return response()->json(auth()->user());
    }

}
