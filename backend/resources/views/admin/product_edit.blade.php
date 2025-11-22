@extends('admin.layout')

@section('title', 'Editar produto')

@section('content')
<div class="card p-4 space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold">Editar produto</h1>
            <p class="text-sm text-slate-600">{{ $produto->nome }}</p>
        </div>
        <a href="{{ route('admin.produtos') }}" class="text-sm text-cyan-700 font-semibold">Voltar</a>
    </div>

    <form method="POST" action="{{ route('admin.produtos.update', $produto) }}" class="space-y-4">
        @csrf @method('PATCH')
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="text-sm font-semibold">Nome</label>
                <input class="input" name="nome" value="{{ old('nome', $produto->nome) }}" required>
            </div>
            <div>
                <label class="text-sm font-semibold">Slug</label>
                <input class="input" name="slug" value="{{ old('slug', $produto->slug) }}" required>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <label class="text-sm font-semibold">Preço</label>
                <input class="input" type="number" step="0.01" name="preco" value="{{ old('preco', $produto->preco) }}" required>
            </div>
            <div>
                <label class="text-sm font-semibold">Preço promocional</label>
                <input class="input" type="number" step="0.01" name="preco_promocional" value="{{ old('preco_promocional', $produto->preco_promocional) }}">
            </div>
            <div>
                <label class="text-sm font-semibold">Categoria</label>
                <select class="input" name="category_id">
                    <option value="">Selecione</option>
                    @foreach($categorias as $c)
                        <option value="{{ $c->id }}" @selected($produto->category_id==$c->id)>{{ $c->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label class="text-sm font-semibold">Clube</label>
                <select class="input" name="club_id">
                    <option value="">Selecione</option>
                    @foreach($clubes as $c)
                        <option value="{{ $c->id }}" @selected($produto->club_id==$c->id)>{{ $c->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold">Liga</label>
                <select class="input" name="league_id">
                    <option value="">Selecione</option>
                    @foreach($ligas as $l)
                        <option value="{{ $l->id }}" @selected($produto->league_id==$l->id)>{{ $l->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="text-sm font-semibold">Descrição</label>
            <textarea class="input" name="descricao" rows="3">{{ old('descricao', $produto->descricao) }}</textarea>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <label class="flex items-center gap-2"><input type="checkbox" name="ativo" value="1" @checked($produto->ativo)> Ativo</label>
            <label class="flex items-center gap-2"><input type="checkbox" name="destaque" value="1" @checked($produto->destaque)> Destaque</label>
            <label class="flex items-center gap-2"><input type="checkbox" name="mais_vendido" value="1" @checked($produto->mais_vendido)> Mais vendido</label>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="card p-4">
                <h3 class="font-semibold mb-2">Imagens</h3>
                <div id="imagens-wrapper" class="space-y-2">
                    @foreach($produto->images as $idx => $img)
                        <div class="flex gap-2">
                            <input class="input" name="imagens_url[]" value="{{ $img->url }}" placeholder="URL da imagem">
                            <input class="input" name="imagens_alt[]" value="{{ $img->alt }}" placeholder="ALT">
                        </div>
                    @endforeach
                    <div class="flex gap-2">
                        <input class="input" name="imagens_url[]" placeholder="URL da imagem">
                        <input class="input" name="imagens_alt[]" placeholder="ALT">
                    </div>
                </div>
                <button type="button" onclick="addImagem()" class="mt-2 text-sm text-cyan-700 font-semibold">+ Adicionar linha</button>
            </div>

            <div class="card p-4">
                <h3 class="font-semibold mb-2">Tamanhos</h3>
                <div id="tamanhos-wrapper" class="space-y-2">
                    @foreach($produto->sizes as $size)
                        <div class="grid grid-cols-3 gap-2">
                            <input class="input" name="tamanho_nome[]" value="{{ $size->tamanho }}" placeholder="P/M/G">
                            <input class="input" name="tamanho_preco[]" value="{{ $size->preco }}" type="number" step="0.01" placeholder="Preço">
                            <input class="input" name="tamanho_estoque[]" value="{{ $size->estoque }}" type="number" placeholder="Estoque">
                        </div>
                    @endforeach
                    <div class="grid grid-cols-3 gap-2">
                        <input class="input" name="tamanho_nome[]" placeholder="P/M/G">
                        <input class="input" name="tamanho_preco[]" type="number" step="0.01" placeholder="Preço">
                        <input class="input" name="tamanho_estoque[]" type="number" placeholder="Estoque">
                    </div>
                </div>
                <button type="button" onclick="addTamanho()" class="mt-2 text-sm text-cyan-700 font-semibold">+ Adicionar linha</button>
            </div>
        </div>

        <button class="btn btn-primary">Salvar alterações</button>
    </form>
</div>

<style>
    .input { @apply w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none; }
    .btn { @apply inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-semibold transition; }
    .btn-primary { @apply bg-cyan-600 text-white hover:bg-cyan-700; }
</style>
<script>
    function addImagem() {
        const wrapper = document.getElementById('imagens-wrapper');
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `<input class="input" name="imagens_url[]" placeholder="URL da imagem">
                         <input class="input" name="imagens_alt[]" placeholder="ALT">`;
        wrapper.appendChild(div);
    }
    function addTamanho() {
        const wrapper = document.getElementById('tamanhos-wrapper');
        const div = document.createElement('div');
        div.className = 'grid grid-cols-3 gap-2';
        div.innerHTML = `<input class="input" name="tamanho_nome[]" placeholder="P/M/G">
                         <input class="input" name="tamanho_preco[]" type="number" step="0.01" placeholder="Preço">
                         <input class="input" name="tamanho_estoque[]" type="number" placeholder="Estoque">`;
        wrapper.appendChild(div);
    }
</script>
@endsection
