@extends('admin.layout')

@section('title', 'Configurações')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-0">Configurações</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Configurações</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="card p-4">
    <h2 class="font-semibold mb-3">Configurações da loja</h2>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="mb-3" data-loading>
        @csrf
        <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label">Nome da loja</label>
                <input class="form-control" name="nome_loja" value="{{ $settings['nome_loja'] ?? '' }}">
            </div>
            <div class="col-sm-6">
                <label class="form-label">E-mail de contato</label>
                <input class="form-control" name="email_contato" value="{{ $settings['email_contato'] ?? '' }}">
            </div>
        </div>
        <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label">Cor primária</label>
                <input class="form-control" name="cor_primaria" value="{{ $settings['cor_primaria'] ?? '' }}" placeholder="#06b6d4">
            </div>
            <div class="col-sm-6">
                <label class="form-label">Texto do rodapé</label>
                <input class="form-control" name="footer_texto" value="{{ $settings['footer_texto'] ?? '' }}">
            </div>
        </div>
        <button class="btn btn-primary">Salvar</button>
    </form>
</div>

@endsection
