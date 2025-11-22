@extends('admin.layout')

@section('title', 'Taxonomias')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="card p-4">
        <h2 class="font-semibold mb-3">Categorias</h2>
        <form method="POST" action="{{ route('admin.categorias.store') }}" class="space-y-2 mb-3" data-loading>
            @csrf
            <input class="input" name="nome" placeholder="Nome" required>
            <input class="input" name="slug" placeholder="slug-exemplo" required>
            <select class="input" name="parent_id">
                <option value="">Pai (opcional)</option>
                @foreach($categorias as $c) <option value="{{ $c->id }}">{{ $c->nome }}</option> @endforeach
            </select>
            <button class="btn btn-primary w-full">Adicionar</button>
        </form>
        <ul class="space-y-1 text-sm">
            @foreach($categorias as $c)
                <li class="flex justify-between">
                    <span>{{ $c->nome }}</span>
                    <form method="POST" action="{{ route('admin.categorias.destroy', $c) }}" onsubmit="return confirm('Remover?')">@csrf @method('DELETE') <button class="text-red-600">x</button></form>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="card p-4">
        <h2 class="font-semibold mb-3">Clubes</h2>
        <form method="POST" action="{{ route('admin.clubes.store') }}" class="space-y-2 mb-3" data-loading>
            @csrf
            <input class="input" name="nome" placeholder="Nome" required>
            <input class="input" name="slug" placeholder="slug-exemplo" required>
            <input class="input" name="pais" placeholder="País">
            <button class="btn btn-primary w-full">Adicionar</button>
        </form>
        <ul class="space-y-1 text-sm">
            @foreach($clubes as $c)
                <li class="flex justify-between">
                    <span>{{ $c->nome }}</span>
                    <form method="POST" action="{{ route('admin.clubes.destroy', $c) }}" onsubmit="return confirm('Remover?')">@csrf @method('DELETE') <button class="text-red-600">x</button></form>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="card p-4">
        <h2 class="font-semibold mb-3">Ligas</h2>
        <form method="POST" action="{{ route('admin.ligas.store') }}" class="space-y-2 mb-3" data-loading>
            @csrf
            <input class="input" name="nome" placeholder="Nome" required>
            <input class="input" name="slug" placeholder="slug-exemplo" required>
            <input class="input" name="pais" placeholder="País">
            <button class="btn btn-primary w-full">Adicionar</button>
        </form>
        <ul class="space-y-1 text-sm">
            @foreach($ligas as $l)
                <li class="flex justify-between">
                    <span>{{ $l->nome }}</span>
                    <form method="POST" action="{{ route('admin.ligas.destroy', $l) }}" onsubmit="return confirm('Remover?')">@csrf @method('DELETE') <button class="text-red-600">x</button></form>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<style>.input { @apply w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-[var(--cor-primaria)] focus:outline-none; }</style>
@endsection
