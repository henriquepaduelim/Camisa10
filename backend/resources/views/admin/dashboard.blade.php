@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="card p-4">
        <div class="text-sm text-slate-500">Produtos</div>
        <div class="text-2xl font-bold">{{ $stats['produtos'] }}</div>
    </div>
    <div class="card p-4">
        <div class="text-sm text-slate-500">Pedidos</div>
        <div class="text-2xl font-bold">{{ $stats['pedidos'] }}</div>
    </div>
    <div class="card p-4">
        <div class="text-sm text-slate-500">Clientes</div>
        <div class="text-2xl font-bold">{{ $stats['clientes'] }}</div>
    </div>
    <div class="card p-4">
        <div class="text-sm text-slate-500">Cupons</div>
        <div class="text-2xl font-bold">{{ $stats['cupons'] }}</div>
    </div>
    <div class="card p-4">
        <div class="text-sm text-slate-500">Carrinhos</div>
        <div class="text-2xl font-bold">{{ $stats['carrinhos'] }}</div>
    </div>
</div>

<div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="card p-4">
        <h2 class="font-semibold mb-2">Pedidos recentes</h2>
        <div class="space-y-2">
            @foreach($pedidosRecentes as $pedido)
                <div class="flex justify-between text-sm">
                    <span>#{{ $pedido->id }} • {{ $pedido->user?->name ?? 'Guest' }}</span>
                    <span class="font-semibold text-brand">{{ ucfirst($pedido->status) }}</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card p-4">
        <h2 class="font-semibold mb-2">Produtos em destaque</h2>
        <div class="space-y-2">
            @foreach($produtosTop as $produto)
                <div class="flex justify-between text-sm">
                    <span>{{ $produto->nome }}</span>
                    <span class="font-semibold">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
