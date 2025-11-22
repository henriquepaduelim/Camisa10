@extends('layouts.app')

@section('title', 'Carrinho')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Carrinho</h1>
    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if($cart->items->isEmpty())
        <div class="bg-white border border-slate-100 rounded-xl p-6 text-center">
            <p class="text-slate-600">Seu carrinho está vazio.</p>
            <a href="/produtos" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 text-white rounded-full font-semibold">Ir para a loja</a>
        </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-4">
            @foreach($cart->items as $item)
        <div class="bg-white border border-slate-100 rounded-xl p-4 flex gap-4 items-center">
            <img class="w-20 h-20 rounded-lg object-cover" src="{{ $item->product->images->first()?->url ?? 'https://via.placeholder.com/200' }}" alt="{{ $item->product->nome }}">
            <div class="flex-1">
                <div class="font-semibold">{{ $item->product->nome }}</div>
                <div class="text-sm text-slate-500">Tamanho: {{ $item->size?->tamanho ?? '-' }}</div>
                <div class="text-sm text-slate-600">Qtd: {{ $item->quantidade }}</div>
            </div>
            <div class="text-right">
                <div class="font-bold text-slate-900">R$ {{ number_format($item->total, 2, ',', '.') }}</div>
                <button class="text-sm text-brand font-semibold">Remover</button>
            </div>
        </div>
            @endforeach
        </div>

        <div class="bg-white border border-slate-100 rounded-xl p-4 space-y-3">
            <h2 class="font-semibold text-lg">Resumo</h2>
            <div class="flex justify-between text-sm">
                <span>Subtotal</span>
                <span>R$ {{ number_format($cart->subtotal, 2, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-brand">
                <span>Descontos</span>
                <span>- R$ {{ number_format($cart->desconto, 2, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-base font-bold border-t pt-3">
                <span>Total</span>
                <span>R$ {{ number_format($cart->total, 2, ',', '.') }}</span>
            </div>
            <a href="/checkout" class="w-full inline-flex justify-center items-center btn btn-primary font-semibold px-4 py-3 rounded-full">Finalizar compra</a>
            <form class="flex gap-2" method="POST" action="/carrinho/cupom" data-loading>
                @csrf
                <input type="text" name="cupom" placeholder="Cupom de desconto" class="flex-1 field-brand" />
                <button data-loading-text="Aplicando..." class="btn btn-secondary px-4 py-2 text-sm font-semibold">Aplicar</button>
            </form>
        </div>
    </div>
    @endif
</section>
@endsection
