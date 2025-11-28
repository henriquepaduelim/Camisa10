@extends('admin.layout')

@section('title', 'Taxonomias')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-0">Taxonomias</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Taxonomias</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card p-4">
            <h2 class="font-semibold mb-3 h5">Categorias</h2>
            <form method="POST" action="{{ route('admin.categorias.store') }}" class="mb-3" data-loading>
                @csrf
                <input class="form-control mb-2" name="nome" placeholder="Nome" required>
                <input class="form-control mb-2" name="slug" placeholder="slug-exemplo" required>
                <select class="form-control mb-2" name="parent_id">
                    <option value="">Pai (opcional)</option>
                    @foreach($categorias as $c) <option value="{{ $c->id }}">{{ $c->nome }}</option> @endforeach
                </select>
                <button class="btn btn-primary w-100">Adicionar</button>
            </form>
            <ul class="list-group list-group-flush">
                @foreach($categorias as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $c->nome }}</span>
                        <form method="POST" action="{{ route('admin.categorias.destroy', $c) }}" onsubmit="return confirm('Remover?')">@csrf @method('DELETE') <button class="btn btn-link btn-sm text-danger p-0">x</button></form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4">
            <h2 class="font-semibold mb-3 h5">Clubes</h2>
            <form method="POST" action="{{ route('admin.clubes.store') }}" class="mb-3" data-loading>
                @csrf
                <input class="form-control mb-2" name="nome" placeholder="Nome" required>
                <input class="form-control mb-2" name="slug" placeholder="slug-exemplo" required>
                <input class="form-control mb-2" name="pais" placeholder="País">
                <button class="btn btn-primary w-100">Adicionar</button>
            </form>
            <ul class="list-group list-group-flush">
                @foreach($clubes as $c)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $c->nome }}</span>
                        <form method="POST" action="{{ route('admin.clubes.destroy', $c) }}" onsubmit="return confirm('Remover?')">@csrf @method('DELETE') <button class="btn btn-link btn-sm text-danger p-0">x</button></form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4">
            <h2 class="font-semibold mb-3 h5">Ligas</h2>
            <form method="POST" action="{{ route('admin.ligas.store') }}" class="mb-3" data-loading>
                @csrf
                <input class="form-control mb-2" name="nome" placeholder="Nome" required>
                <input class="form-control mb-2" name="slug" placeholder="slug-exemplo" required>
                <input class="form-control mb-2" name="pais" placeholder="País">
                <button class="btn btn-primary w-100">Adicionar</button>
            </form>
            <ul class="list-group list-group-flush">
                @foreach($ligas as $l)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $l->nome }}</span>
                        <form method="POST" action="{{ route('admin.ligas.destroy', $l) }}" onsubmit="return confirm('Remover?')">@csrf @method('DELETE') <button class="btn btn-link btn-sm text-danger p-0">x</button></form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
