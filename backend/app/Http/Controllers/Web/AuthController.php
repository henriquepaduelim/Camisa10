<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/conta')->with('success', 'Bem-vindo de volta!');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'required' => 'Campo obrigatório.',
            'email' => 'Informe um e-mail válido.',
            'unique' => 'E-mail já cadastrado.',
            'confirmed' => 'Confirmação de senha não confere.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'telefone' => $data['telefone'] ?? null,
            'password' => $data['password'],
        ]);

        Auth::login($user);

        return redirect('/conta')->with('success', 'Conta criada com sucesso.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sessão encerrada.');
    }
}
