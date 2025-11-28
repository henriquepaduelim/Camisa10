@extends('layouts.app')

@section('title', 'Loja mobile de camisas')

@section('content')
@php
    $heroProduct = $destaques->first() ?? $maisVendidos->first();
    $heroImage = $heroProduct?->images->first()?->url ?? asset('images/placeholder-shirt.svg');
@endphp
<section class="relative overflow-hidden text-white">
    <video class="absolute inset-0 w-full h-full object-cover filter grayscale" autoplay muted loop playsinline>
        <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-linear-to-br from-[rgba(0,0,0,0.75)] via-[rgba(0,0,0,0.55)] to-[rgba(0,0,0,0.7)]"></div>
    <div class="relative max-w-6xl mx-auto px-4 py-12 sm:py-16 flex flex-col sm:flex-row gap-8 items-center">
        <div class="flex-1 space-y-4">
            <p class="text-sm uppercase tracking-wide text-slate-100">Nova coleção</p>
            <h1 class="text-3xl sm:text-4xl font-bold leading-tight">Camisas oficiais e retrô, feitas para quem vive futebol 24/7.</h1>
            <p class="text-slate-100">Escolha seu clube ou seleção favorita, com entrega rápida e experiência otimizada para smartphones.</p>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="/produtos" class="btn btn-primary font-semibold px-5 py-3 rounded-full inline-flex items-center justify-center gap-2">
                    <i class="fa-solid fa-shirt"></i> Confira!
                </a>
                <a href="/checkout" class="btn btn-secondary inline-flex items-center justify-center gap-2 font-semibold px-5 py-3 rounded-full hover:bg-white/10 transition border border-brand text-white">
                    <i class="fa-solid fa-bolt"></i> Comprar agora
                </a>
            </div>
            <div class="flex items-center gap-4 text-sm text-slate-100">
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-shield-halved"></i> Pagamento seguro</span>
                <span class="inline-flex items-center gap-2"><i class="fa-solid fa-truck-fast"></i> Envio rápido</span>
            </div>
        </div>
        <div class="flex-1 w-full">
            <div class="bg-white/10 border border-white/10 rounded-3xl p-4 shadow-lg backdrop-blur">
                <img src="{{ $heroImage }}" alt="h-96" class="w-full rounded-2xl object-cover h-96">
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 py-10">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold">Destaques</h2>
        <a href="/produtos?filtro=destaque" class="text-sm text-brand font-semibold">Ver tudo</a>
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
        <a href="/produtos?filtro=mais_vendido" class="text-sm text-brand font-semibold">Ver tudo</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($maisVendidos as $produto)
            <x-product-card :produto="$produto" />
        @endforeach
    </div>
</section>
@endsection
