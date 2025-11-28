@extends('admin.layout')

@section('title', 'Pedidos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-0">Pedidos</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="card p-4 overflow-auto">
    <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-3">
        <h2 class="font-semibold h5 mb-0">Pedidos</h2>
        <form method="GET" class="w-100 w-sm-auto d-flex flex-column flex-sm-row gap-2">
            <input class="form-control form-control-sm" style="max-width: 200px" name="q" value="{{ $filtros['q'] ?? '' }}" placeholder="Buscar por ID, nome ou e-mail">
            <select class="form-control form-control-sm" name="status" style="max-width: 150px">
                <option value="">Status</option>
                @foreach(['pendente','pago','enviado','entregue','cancelado'] as $status)
                    <option value="{{ $status }}" @selected(($filtros['status'] ?? '')===$status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <input class="form-control form-control-sm" style="max-width: 160px" type="date" name="data" value="{{ $filtros['data'] ?? '' }}">
            <button class="btn btn-primary btn-sm w-100 w-sm-auto">Filtrar</button>
        </form>
    </div>
    <table class="table table-sm align-middle">
        <thead>
            <tr class="text-muted">
                <th>ID</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Total</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedidos as $p)
                <tr>
                    <td class="align-top">
                        <div class="fw-semibold">#{{ $p->id }}</div>
                        <div class="text-muted small">{{ $p->created_at->format('d/m H:i') }}</div>
                    </td>
                    <td class="align-top">
                        <div>{{ $p->user?->name ?? 'Guest' }}</div>
                        <div class="text-muted small">{{ $p->user?->email }}</div>
                    </td>
                    <td class="align-top"><span class="badge bg-info text-dark text-capitalize">{{ $p->status }}</span></td>
                    <td class="align-top">R$ {{ number_format($p->total, 2, ',', '.') }}</td>
                    <td class="align-top">
                        <form method="POST" action="{{ route('admin.pedidos.status', $p) }}" class="d-flex flex-column flex-sm-row align-items-sm-center gap-2" data-loading>
                            @csrf @method('PATCH')
                            <select name="status" class="form-control form-control-sm">
                                @foreach(['pendente','pago','enviado','entregue','cancelado'] as $status)
                                    <option value="{{ $status }}" @selected($p->status === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <input class="form-control form-control-sm" name="comentario" placeholder="Comentário opcional" value="Atualizado via painel">
                            <button class="btn btn-primary btn-sm">Atualizar</button>
                        </form>
                        <div class="mt-2 text-muted small">
                            <div class="fw-semibold">Itens:</div>
                            @foreach($p->items as $item)
                                <div>- {{ $item->nome }} x{{ $item->quantidade }} @if($item->tamanho) ({{ $item->tamanho }}) @endif</div>
                            @endforeach
                            @if($p->address)
                                <div class="fw-semibold mt-1">Entrega:</div>
                                <div>{{ $p->address->rua }}, {{ $p->address->numero }} - {{ $p->address->cidade }}/{{ $p->address->estado }}</div>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3">{{ $pedidos->links() }}</div>
</div>
@endsection
