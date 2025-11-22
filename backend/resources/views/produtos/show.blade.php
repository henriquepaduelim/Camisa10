@extends('layouts.app')

@section('title', $produto->nome)

@section('content')
<section class="max-w-6xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <img src="{{ $produto->images->first()?->url ?? 'https://via.placeholder.com/900x900?text=Camisa' }}" alt="{{ $produto->nome }}" class="w-full object-cover">
            </div>
            <div class="grid grid-cols-4 gap-2">
                @foreach($produto->images as $imagem)
                    <img src="{{ $imagem->url }}" alt="{{ $imagem->alt }}" class="rounded-xl border border-slate-100">
                @endforeach
            </div>
        </div>

        <div class="space-y-4">
            <div class="text-sm text-slate-500 uppercase tracking-wide">{{ $produto->club?->nome ?? $produto->league?->nome }}</div>
            <h1 class="text-2xl font-bold">{{ $produto->nome }}</h1>
            <p class="text-slate-700">{{ $produto->descricao }}</p>

            <div class="flex items-center gap-3">
                <span class="text-3xl font-bold text-slate-900">R$ {{ number_format($produto->preco_promocional ?? $produto->preco, 2, ',', '.') }}</span>
                @if($produto->preco_promocional)
                    <span class="text-lg line-through text-slate-400">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                @endif
            </div>

            <form class="space-y-4" method="POST" action="/carrinho">
                @csrf
                <input type="hidden" name="product_id" value="{{ $produto->id }}">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Tamanhos</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach($produto->sizes as $size)
                            <label class="cursor-pointer">
                                <input required type="radio" name="product_size_id" value="{{ $size->id }}" class="peer sr-only">
                                <span class="peer-checked:bg-cyan-600 peer-checked:text-white inline-flex items-center justify-center px-3 py-2 rounded-full border border-slate-200 text-sm">{{ $size->tamanho }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('product_size_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Quantidade</label>
                    <input type="number" name="quantidade" min="1" value="1" class="w-24 rounded-xl border border-slate-200 px-3 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-2">
                    <button class="bg-cyan-600 text-white font-semibold px-5 py-3 rounded-full hover:bg-cyan-700 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i> Adicionar ao carrinho
                    </button>
                    <a href="/checkout" class="text-center border border-cyan-600 text-cyan-700 font-semibold px-5 py-3 rounded-full hover:bg-cyan-50 transition">Comprar agora</a>
                </div>
                <div class="text-sm text-slate-600 flex flex-col gap-1">
                    <span><i class="fa-solid fa-truck-fast mr-2 text-cyan-600"></i>Envio rápido para todo o Brasil</span>
                    <span><i class="fa-solid fa-shield-halved mr-2 text-cyan-600"></i>Pagamento seguro</span>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Relacionados</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($relacionados as $produtoRelacionado)
                <x-product-card :produto="$produtoRelacionado" />
            @endforeach
        </div>
    </div>
</section>
@endsection
