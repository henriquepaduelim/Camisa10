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
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field-brand">
            @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="password">Senha</label>
            <input id="password" name="password" type="password" required class="field-brand">
            @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="flex items-center gap-2">
            <input id="remember" name="remember" type="checkbox" class="accent-[var(--cor-primaria)]">
            <label for="remember" class="text-sm text-slate-600">Lembrar-me</label>
        </div>
        <button data-loading-text="Entrando..." class="w-full btn btn-primary font-semibold px-4 py-3 rounded-full">Entrar</button>
        <p class="text-sm text-center text-slate-600">Ainda não tem conta? <a href="/registrar" class="text-brand font-semibold">Criar conta</a></p>
    </form>
</section>
@endsection
