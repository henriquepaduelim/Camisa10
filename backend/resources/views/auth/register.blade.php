@extends('layouts.app')

@section('title', 'Registrar')

@section('content')
<section class="max-w-md mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-4">Criar conta</h1>
    <form method="POST" action="/registrar" class="bg-white border border-slate-100 rounded-xl p-5 space-y-4 shadow-sm" data-loading>
        @csrf
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="name">Nome completo</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="field-brand">
            @error('name') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="email">E-mail</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="field-brand">
            @error('email') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="telefone">Telefone</label>
            <input id="telefone" name="telefone" type="text" value="{{ old('telefone') }}" class="field-brand">
            @error('telefone') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="password">Senha</label>
            <input id="password" name="password" type="password" required class="field-brand">
            @error('password') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div class="space-y-1">
            <label class="text-sm font-semibold text-slate-700" for="password_confirmation">Confirmar senha</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="field-brand">
        </div>
        <button data-loading-text="Criando..." class="w-full btn btn-primary font-semibold px-4 py-3 rounded-full">Criar conta</button>
        <p class="text-sm text-center text-slate-600">Já tem conta? <a href="/login" class="text-brand font-semibold">Entrar</a></p>
    </form>
</section>
@endsection
