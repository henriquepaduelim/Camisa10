@extends('layouts.app')

@section('title', 'Catálogo')

@section('content')
<section class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Catálogo</h1>
            <p class="text-sm text-slate-600">Filtros por clube, liga, categoria e preço.</p>
        </div>
        <form method="GET" class="flex gap-2">
            <select name="ordem" class="rounded-full border border-slate-200 px-3 py-2 text-sm">
                <option value="">Ordenar</option>
                <option value="preco_asc">Preço: menor</option>
                <option value="preco_desc">Preço: maior</option>
                <option value="recentes">Novidades</option>
                <option value="populares">Populares</option>
            </select>
            <button class="px-4 py-2 bg-cyan-600 text-white rounded-full text-sm font-semibold hover:bg-cyan-700">Aplicar</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
        <aside class="sm:col-span-1 space-y-4">
            <form method="GET" class="space-y-3">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Clube</label>
                    <select name="clube" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="">Todos</option>
                        @foreach($clubes as $clube)
                            <option value="{{ $clube->slug }}">{{ $clube->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Liga</label>
                    <select name="liga" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="">Todas</option>
                        @foreach($ligas as $liga)
                            <option value="{{ $liga->slug }}">{{ $liga->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Categoria</label>
                    <select name="categoria" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm">
                        <option value="">Todas</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->slug }}">{{ $categoria->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Preço mín.</label>
                        <input name="preco_min" type="number" step="0.01" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="0" />
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Preço máx.</label>
                        <input name="preco_max" type="number" step="0.01" class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm" placeholder="1000" />
                    </div>
                </div>
                <button class="w-full bg-cyan-600 text-white py-2 rounded-xl font-semibold text-sm hover:bg-cyan-700">Filtrar</button>
            </form>
        </aside>

        <div class="sm:col-span-3">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4">
                @foreach($produtos as $produto)
                    <x-product-card :produto="$produto" />
                @endforeach
            </div>
            <div class="mt-6">
                {{ $produtos->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
