@extends('admin.layout')

@section('title', 'Cupons')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-0">Cupons</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cupons</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card p-4">
            <h2 class="font-semibold mb-3 h5">Novo cupom</h2>
            <form method="POST" action="{{ route('admin.cupons.store') }}" class="space-y-3" data-loading>
                @csrf
                <div class="row g-2">
                    <div class="col-sm-6"><input class="form-control" name="codigo" placeholder="CODIGO10" required></div>
                    <div class="col-sm-6">
                        <select class="form-control" name="tipo">
                            <option value="percentual">Percentual</option>
                            <option value="fixo">Fixo</option>
                        </select>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-sm-4"><input class="form-control" name="valor" type="number" step="0.01" placeholder="Valor" required></div>
                    <div class="col-sm-4"><input class="form-control" name="valor_minimo" type="number" step="0.01" placeholder="Valor mínimo"></div>
                    <div class="col-sm-4"><input class="form-control" name="limite_uso" type="number" placeholder="Limite de uso"></div>
                </div>
                <input class="form-control" name="expira_em" type="date">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo-cupom" checked>
                    <label class="form-check-label" for="ativo-cupom">Ativo</label>
                </div>
                <button class="btn btn-primary w-100">Salvar</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card p-4 overflow-auto space-y-3">
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <h2 class="font-semibold h5 mb-0">Cupons</h2>
                <form method="GET" class="w-100 w-sm-auto d-flex flex-column flex-sm-row gap-2">
                    <input class="form-control form-control-sm" style="max-width: 160px" name="q" value="{{ $filtros['q'] ?? '' }}" placeholder="Buscar código">
                    <select class="form-control form-control-sm" name="ativo" style="max-width: 120px">
                        <option value="">Ativo?</option>
                        <option value="1" @selected(($filtros['ativo'] ?? '')==='1')>Sim</option>
                        <option value="0" @selected(($filtros['ativo'] ?? '')==='0')>Não</option>
                    </select>
                    <select class="form-control form-control-sm" name="expirado" style="max-width: 150px">
                        <option value="">Expiração</option>
                        <option value="nao" @selected(($filtros['expirado'] ?? '')==='nao')>Válidos</option>
                        <option value="sim" @selected(($filtros['expirado'] ?? '')==='sim')>Expirados</option>
                    </select>
                    <button class="btn btn-primary btn-sm w-100 w-sm-auto">Filtrar</button>
                </form>
            </div>
            <table class="table table-sm align-middle">
                <thead><tr class="text-muted"><th>Código</th><th>Tipo</th><th>Valor</th><th>Ativo</th><th class="text-end">Ações</th></tr></thead>
                <tbody>
                    @foreach($cupons as $c)
                        <tr>
                            <td class="fw-semibold">{{ $c->codigo }}</td>
                            <td>{{ $c->tipo }}</td>
                            <td>{{ $c->valor }}</td>
                            <td class="text-nowrap">
                                <span class="{{ $c->ativo ? 'text-primary' : 'text-muted' }}">
                                    {{ $c->ativo ? 'Sim' : 'Não' }}
                                </span>
                                @if($c->expira_em)
                                    <div class="text-muted small">Expira {{ $c->expira_em->format('d/m/Y') }}</div>
                                @endif
                            </td>
                            <td class="text-end">
                                <form method="POST" action="{{ route('admin.cupons.ativo', $c) }}" class="d-inline" data-loading>
                                    @csrf @method('PATCH')
                                    <button class="btn btn-link btn-sm p-0 text-primary">Toggle ativo</button>
                                </form>
                                <form method="POST" action="{{ route('admin.cupons.destroy', $c) }}" class="d-inline" onsubmit="return confirm('Remover?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-link btn-sm p-0 text-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>{{ $cupons->links() }}</div>
        </div>
    </div>
</div>
@endsection
