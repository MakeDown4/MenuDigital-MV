<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $erro = '';

        if ($request->get('erro') == 1) {
            $erro = 'Usuário e ou senha não existe';
        };

        if ($request->get('erro') == 2) {
            $erro = 'Necessário realizar login para ter acesso á página';
        };

        return Inertia::render('Login', ['erro' => $erro]);
    }

    public function autenticar(Request $request)
    {
        $regras = [
            'usuario' => 'email',
            'senha' => 'required'
        ];
    
        $feedback = [
            'usuario.email' => 'O campo usuário (e-mail) é obrigatório',
            'senha.required' => 'O campo senha é obrigatório'
        ];
    
        $request->validate($regras, $feedback);
    
        $email = $request->get('usuario');
        $password = $request->get('senha');
    
        $user = new User();
    
        $usuario = $user->where('email', $email)->where('password', $password)->get()->first();
    
        if (isset($usuario->name)) {
            // Criar dados para serem usados na view
            $data = [
                'nome' => $usuario->name,
                'email' => $usuario->email
            ];
    
            // Retornar resposta do Inertia
            return inertia('Dashboard', $data);
        } else {
            // Criar dados para serem usados na view
            $data = [
                'erro' => 'Usuário e ou senha não existem'
            ];
    
            // Retornar resposta do Inertia
            return inertia('Login', $data)->withViewData(['erro' => 1]);
        }
    }

    public function sair(Request $request)
    {
        Auth::logout();
        return redirect()->route('site.home');
    }
}