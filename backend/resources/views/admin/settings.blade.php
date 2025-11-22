@extends('admin.layout')

@section('title', 'Configurações')

@section('content')
<div class="card p-4">
    <h2 class="font-semibold mb-3">Configurações da loja</h2>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-3" data-loading>
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="text-sm font-semibold">Nome da loja</label>
                <input class="input" name="nome_loja" value="{{ $settings['nome_loja'] ?? '' }}">
            </div>
            <div>
                <label class="text-sm font-semibold">E-mail de contato</label>
                <input class="input" name="email_contato" value="{{ $settings['email_contato'] ?? '' }}">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="text-sm font-semibold">Cor primária</label>
                <input class="input" name="cor_primaria" value="{{ $settings['cor_primaria'] ?? '' }}" placeholder="#06b6d4">
            </div>
            <div>
                <label class="text-sm font-semibold">Texto do rodapé</label>
                <input class="input" name="footer_texto" value="{{ $settings['footer_texto'] ?? '' }}">
            </div>
        </div>
        <button class="btn btn-primary">Salvar</button>
    </form>
</div>

<style>.input { @apply w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none; } .btn { @apply inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-semibold transition; } .btn-primary { @apply bg-cyan-600 text-white hover:bg-cyan-700; }</style>
@endsection
