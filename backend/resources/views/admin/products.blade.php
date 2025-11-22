@extends('admin.layout')

@section('title', 'Produtos')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card p-4">
        <h2 class="font-semibold mb-3">Novo produto</h2>
        <form method="POST" action="{{ route('admin.produtos.store') }}" class="space-y-3" data-loading enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <input class="input" name="nome" placeholder="Nome" required>
                <input class="input" name="slug" placeholder="slug-exemplo" required>
                <input class="input" name="preco" type="number" step="0.01" placeholder="Preço" required>
                <input class="input" name="preco_promocional" type="number" step="0.01" placeholder="Preço promocional">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <select class="input" name="category_id">
                    <option value="">Categoria</option>
                    @foreach($categorias as $c)
                        <option value="{{ $c->id }}">{{ $c->nome }}</option>
                    @endforeach
                </select>
                <select class="input" name="club_id">
                    <option value="">Clube</option>
                    @foreach($clubes as $c)
                        <option value="{{ $c->id }}">{{ $c->nome }}</option>
                    @endforeach
                </select>
                <select class="input" name="league_id">
                    <option value="">Liga</option>
                    @foreach($ligas as $l)
                        <option value="{{ $l->id }}">{{ $l->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-4 text-sm">
                <label class="flex items-center gap-2"><input type="checkbox" name="ativo" value="1" checked class="accent-[var(--cor-primaria)]"> Ativo</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="destaque" value="1" class="accent-[var(--cor-primaria)]"> Destaque</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="mais_vendido" value="1" class="accent-[var(--cor-primaria)]"> Mais vendido</label>
            </div>
            <button class="btn btn-primary w-full">Salvar</button>
        </form>
    </div>

    <div class="card p-4 overflow-auto">
        <h2 class="font-semibold mb-3">Produtos</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-600">
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($produtos as $p)
                    <tr>
                        <td class="py-2">
                            <div class="font-semibold">{{ $p->nome }}</div>
                            <div class="text-xs text-slate-500">{{ $p->slug }}</div>
                        </td>
                        <td class="py-2">R$ {{ number_format($p->preco, 2, ',', '.') }}</td>
                        <td class="py-2 text-xs">
                            @if($p->ativo) <span class="text-brand font-semibold">Ativo</span> @else <span class="text-slate-500">Inativo</span> @endif
                        </td>
                        <td class="py-2">
                            <a class="text-xs text-brand font-semibold" href="{{ route('admin.produtos.edit', $p) }}">Editar</a>
                            <form method="POST" action="{{ route('admin.produtos.update', $p) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="nome" value="{{ $p->nome }}">
                                <input type="hidden" name="slug" value="{{ $p->slug }}">
                                <input type="hidden" name="preco" value="{{ $p->preco }}">
                                <input type="hidden" name="preco_promocional" value="{{ $p->preco_promocional }}">
                                <input type="hidden" name="category_id" value="{{ $p->category_id }}">
                                <input type="hidden" name="club_id" value="{{ $p->club_id }}">
                                <input type="hidden" name="league_id" value="{{ $p->league_id }}">
                                <input type="hidden" name="ativo" value="{{ $p->ativo ? 0 : 1 }}">
                                <button class="text-xs text-cyan-700 font-semibold">Toggle ativo</button>
                            </form>
                            <form method="POST" action="{{ route('admin.produtos.destroy', $p) }}" class="inline" onsubmit="return confirm('Remover?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-600 font-semibold ml-2">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            {{ $produtos->links() }}
        </div>
    </div>
</div>

<style>
    .input { @apply w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none; }
</style>
@endsection
