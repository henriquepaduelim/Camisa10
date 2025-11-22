<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'required' => 'Campo obrigatório.',
            'email' => 'Informe um e-mail válido.',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput();
        }

        $user = $request->user();
        if (!$user->isAdmin()) {
            Auth::logout();
            return back()->withErrors(['email' => 'Acesso restrito ao administrador.'])->withInput();
        }

        $request->session()->regenerate();

        return redirect('/admin')->with('success', 'Bem-vindo ao painel.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')->with('success', 'Sessão encerrada.');
    }
}
