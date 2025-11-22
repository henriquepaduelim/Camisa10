@extends('layouts.app')

@section('title', 'Registrar')

@section('content')
<section class="max-w-md mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-4">Criar conta</h1>
    <form method="POST" action="/registrar" class="bg-white border border-slate-100 rounded-xl p-5 space-y-4 shadow-sm">
        @csrf
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="name">Nome completo</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none">
            @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="email">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none">
            @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="telefone">Telefone</label>
            <input id="telefone" name="telefone" type="text" value="{{ old('telefone') }}" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none">
            @error('telefone') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="password">Senha</label>
            <input id="password" name="password" type="password" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none">
            @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="password_confirmation">Confirmar senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none">
        </div>
        <button class="w-full bg-cyan-600 text-white font-semibold px-4 py-3 rounded-full hover:bg-cyan-700 transition">Criar conta</button>
        <p class="text-sm text-center text-slate-600">Já tem conta? <a href="/login" class="text-cyan-700 font-semibold">Entrar</a></p>
    </form>
</section>
@endsection
