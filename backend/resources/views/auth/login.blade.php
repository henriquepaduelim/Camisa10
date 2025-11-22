@extends('layouts.app')

@section('title', 'Entrar')

@section('content')
<section class="max-w-md mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-4">Entrar</h1>
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="/login" class="bg-white border border-slate-100 rounded-xl p-5 space-y-4 shadow-sm" data-loading>
        @csrf
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="email">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none">
            @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="password">Senha</label>
            <input id="password" name="password" type="password" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none">
            @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex items-center gap-2">
            <input id="remember" name="remember" type="checkbox" class="accent-cyan-600">
            <label for="remember" class="text-sm text-slate-600">Lembrar-me</label>
        </div>
        <button data-loading-text="Entrando..." class="w-full bg-cyan-600 text-white font-semibold px-4 py-3 rounded-full hover:bg-cyan-700 transition">Entrar</button>
        <p class="text-sm text-center text-slate-600">Ainda não tem conta? <a href="/registrar" class="text-cyan-700 font-semibold">Criar conta</a></p>
    </form>
</section>
@endsection
