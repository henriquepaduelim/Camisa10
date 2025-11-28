@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    @foreach([
        ['label' => 'Produtos', 'value' => $stats['produtos'], 'icon' => 'fas fa-box'],
        ['label' => 'Pedidos', 'value' => $stats['pedidos'], 'icon' => 'fas fa-shopping-cart'],
        ['label' => 'Clientes', 'value' => $stats['clientes'], 'icon' => 'fas fa-user'],
        ['label' => 'Cupons', 'value' => $stats['cupons'], 'icon' => 'fas fa-ticket-alt'],
        ['label' => 'Carrinhos', 'value' => $stats['carrinhos'], 'icon' => 'fas fa-shopping-bag'],
    ] as $card)
        <div class="col-sm-6 col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">{{ $card['label'] }}</div>
                        <div class="h4 mb-0 fw-bold">{{ $card['value'] }}</div>
                    </div>
                    <i class="{{ $card['icon'] }} text-primary fs-3"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row mt-3">
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title">Pedidos recentes</h3>
            </div>
            <div class="card-body">
                @foreach($pedidosRecentes as $pedido)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>#{{ $pedido->id }} • {{ $pedido->user?->name ?? 'Guest' }}</span>
                        <span class="badge bg-info text-dark text-capitalize">{{ $pedido->status }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title">Produtos em destaque</h3>
            </div>
            <div class="card-body">
                @foreach($produtosTop as $produto)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>{{ $produto->nome }}</span>
                        <span class="fw-semibold">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
