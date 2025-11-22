@extends('layouts.app')

@section('title', 'Loja mobile de camisas')

@section('content')
<section class="bg-gradient-to-br from-cyan-600 to-cyan-800 text-white">
    <div class="max-w-6xl mx-auto px-4 py-10 sm:py-14 flex flex-col sm:flex-row gap-8 items-center">
        <div class="flex-1 space-y-4">
            <p class="text-sm uppercase tracking-wide text-cyan-200">Nova coleção</p>
            <h1 class="text-3xl sm:text-4xl font-bold leading-tight">Camisas oficiais e retrô, feitas para quem vive futebol 24/7.</h1>
            <p class="text-cyan-100">Escolha seu clube ou seleção favorita, com entrega rápida e experiência otimizada para smartphones.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="/produtos" class="inline-flex items-center justify-center gap-2 bg-white text-cyan-800 font-semibold px-5 py-3 rounded-full hover:bg-slate-100 transition">
                    <i class="fa-solid fa-shirt"></i> Ver catálogo
                </a>
                <a href="/checkout" class="inline-flex items-center justify-center gap-2 border border-white/60 text-white font-semibold px-5 py-3 rounded-full hover:bg-white/10 transition">
                    <i class="fa-solid fa-bolt"></i> Comprar agora
                </a>
            </div>
            <div class="flex items-center gap-4 text-sm text-cyan-100">
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-shield-halved"></i> Pagamento seguro</span>
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-truck-fast"></i> Envio rápido</span>
            </div>
        </div>
        <div class="flex-1 w-full">
            <div class="bg-white/10 border border-white/10 rounded-3xl p-4 shadow-lg backdrop-blur">
                <img src="https://via.placeholder.com/900x900?text=Camisa+Futebol" alt="Camisa destaque" class="w-full rounded-2xl object-cover">
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Destaques</h2>
        <a href="/produtos?filtro=destaque" class="text-sm text-cyan-700 font-semibold">Ver tudo</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($destaques as $produto)
            <x-product-card :produto="$produto" />
        @endforeach
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 pb-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Mais vendidos</h2>
        <a href="/produtos?filtro=mais_vendido" class="text-sm text-cyan-700 font-semibold">Ver tudo</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($maisVendidos as $produto)
            <x-product-card :produto="$produto" />
        @endforeach
    </div>
</section>
@endsection
