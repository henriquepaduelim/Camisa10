@extends('admin.layout')

@section('title', 'Editar produto')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-0">Editar produto</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.produtos') }}">Produtos</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $produto->nome }}</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h2 class="h5 mb-1">Editar produto</h2>
            <p class="text-muted small mb-0">{{ $produto->nome }}</p>
        </div>
        <a href="{{ route('admin.produtos') }}" class="btn btn-link">Voltar</a>
    </div>

    <form method="POST" action="{{ route('admin.produtos.update', $produto) }}" class="mb-3" enctype="multipart/form-data">
        @csrf @method('PATCH')
        <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label">Nome</label>
                <input class="form-control" name="nome" value="{{ old('nome', $produto->nome) }}" required data-slug-source data-slug-target="#slug-editar">
            </div>
            <div class="col-sm-6">
                <label class="form-label">Slug</label>
                <input class="form-control" id="slug-editar" name="slug" value="{{ old('slug', $produto->slug) }}" required>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-sm-4">
                <label class="form-label">Preço</label>
                <input class="form-control" type="number" step="0.01" name="preco" value="{{ old('preco', $produto->preco) }}" required>
            </div>
            <div class="col-sm-4">
                <label class="form-label">Preço promocional</label>
                <input class="form-control" type="number" step="0.01" name="preco_promocional" value="{{ old('preco_promocional', $produto->preco_promocional) }}">
            </div>
            <div class="col-sm-4">
                <label class="form-label">Categoria</label>
                <select class="form-control" name="category_id">
                    <option value="">Selecione</option>
                    @foreach($categorias as $c)
                        <option value="{{ $c->id }}" @selected($produto->category_id==$c->id)>{{ $c->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label">Clube</label>
                <select class="form-control" name="club_id">
                    <option value="">Selecione</option>
                    @foreach($clubes as $c)
                        <option value="{{ $c->id }}" @selected($produto->club_id==$c->id)>{{ $c->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6">
                <label class="form-label">Liga</label>
                <select class="form-control" name="league_id">
                    <option value="">Selecione</option>
                    @foreach($ligas as $l)
                        <option value="{{ $l->id }}" @selected($produto->league_id==$l->id)>{{ $l->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div>
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao" rows="3">{{ old('descricao', $produto->descricao) }}</textarea>
        </div>
        <div class="row g-3">
            <div class="col-sm-6">
                <label class="form-label">Descrição curta</label>
                <input class="form-control" name="descricao_curta" value="{{ old('descricao_curta', $produto->descricao_curta) }}">
            </div>
            <div class="col-sm-6">
                <label class="form-label">Meta title</label>
                <input class="form-control" name="meta_title" value="{{ old('meta_title', $produto->meta_title) }}">
            </div>
        </div>
        <div>
            <label class="form-label">Meta description</label>
            <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $produto->meta_description) }}</textarea>
        </div>
        <div class="d-flex flex-wrap gap-3 small">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo-editar" @checked($produto->ativo)>
                <label class="form-check-label" for="ativo-editar">Ativo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="destaque" value="1" id="destaque-editar" @checked($produto->destaque)>
                <label class="form-check-label" for="destaque-editar">Destaque</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="hero" value="1" id="hero-editar" @checked($produto->hero)>
                <label class="form-check-label" for="hero-editar">Hero</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="mais_vendido" value="1" id="maisvendido-editar" @checked($produto->mais_vendido)>
                <label class="form-check-label" for="maisvendido-editar">Mais vendido</label>
            </div>
        </div>
        <div class="col-sm-4">
            <label class="form-label">Ordem no hero (1-10)</label>
            <input class="form-control" name="hero_order" type="number" min="1" max="10" value="{{ old('hero_order', $produto->hero_order) }}" placeholder="Ex.: 1">
            <div class="form-text">Use para ordenar os itens do carrossel (máx. 3 marcados).</div>
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card p-3">
                    <h3 class="h6 fw-semibold">Imagens</h3>
                    <div id="imagens-wrapper" class="d-flex flex-column gap-2">
                        @foreach($produto->images as $idx => $img)
                            <div class="d-flex gap-2 align-items-center imagem-row">
                                <input class="form-control" name="imagens_url[]" value="{{ $img->url }}" placeholder="URL da imagem" data-url-preview-source oninput="updateUrlPreview(this)">
                                <input class="form-control" name="imagens_alt[]" value="{{ $img->alt }}" placeholder="ALT">
                                <label class="form-check form-check-inline small mb-0">
                                    <input class="form-check-input" type="radio" name="imagens_principal" value="{{ $idx }}" @checked($img->principal || $idx===0)> Principal
                                </label>
                                <div class="thumb bg-light rounded d-flex align-items-center justify-content-center overflow-hidden">
                                    <img data-url-preview src="{{ $img->url }}" class="thumb-img" alt="">
                                </div>
                                <div class="d-flex flex-column gap-1 small">
                                    <button type="button" class="btn btn-link p-0 text-primary" onclick="moveImage(this, 'up')">↑</button>
                                    <button type="button" class="btn btn-link p-0 text-primary" onclick="moveImage(this, 'down')">↓</button>
                                    <button type="button" class="btn btn-link p-0 text-danger" onclick="removeImage(this)">x</button>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex gap-2 align-items-center imagem-row">
                            <input class="form-control" name="imagens_url[]" placeholder="URL da imagem" data-url-preview-source oninput="updateUrlPreview(this)">
                            <input class="form-control" name="imagens_alt[]" placeholder="ALT">
                            <label class="form-check form-check-inline small mb-0">
                                <input class="form-check-input" type="radio" name="imagens_principal" value="{{ max(1, $produto->images->count()) }}"> Principal
                            </label>
                            <div class="thumb bg-light rounded d-flex align-items-center justify-content-center overflow-hidden">
                                <img data-url-preview class="thumb-img d-none" alt="">
                            </div>
                            <div class="d-flex flex-column gap-1 small">
                                <button type="button" class="btn btn-link p-0 text-primary" onclick="moveImage(this, 'up')">↑</button>
                                <button type="button" class="btn btn-link p-0 text-primary" onclick="moveImage(this, 'down')">↓</button>
                                <button type="button" class="btn btn-link p-0 text-danger" onclick="removeImage(this)">x</button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex flex-column gap-2">
                        <label class="form-label">Upload de imagens</label>
                        <input type="file" id="upload-editar" name="imagens_upload[]" multiple class="form-control form-control-sm">
                        <div id="upload-preview-editar" class="d-flex gap-2 flex-wrap"></div>
                    </div>
                    <button type="button" onclick="addImagem()" class="btn btn-link p-0 text-primary">+ Adicionar linha</button>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card p-3">
                    <h3 class="h6 fw-semibold">Tamanhos</h3>
                    <div id="tamanhos-wrapper" class="d-flex flex-column gap-2">
                        @foreach($produto->sizes as $size)
                            <div class="row g-2">
                                <div class="col-4"><input class="form-control" name="tamanho_nome[]" value="{{ $size->tamanho }}" placeholder="P/M/G"></div>
                                <div class="col-4"><input class="form-control" name="tamanho_preco[]" value="{{ $size->preco }}" type="number" step="0.01" placeholder="Preço"></div>
                                <div class="col-4"><input class="form-control" name="tamanho_estoque[]" value="{{ $size->estoque }}" type="number" placeholder="Estoque"></div>
                            </div>
                        @endforeach
                        <div class="row g-2">
                            <div class="col-4"><input class="form-control" name="tamanho_nome[]" placeholder="P/M/G"></div>
                            <div class="col-4"><input class="form-control" name="tamanho_preco[]" type="number" step="0.01" placeholder="Preço"></div>
                            <div class="col-4"><input class="form-control" name="tamanho_estoque[]" type="number" placeholder="Estoque"></div>
                        </div>
                    </div>
                    <button type="button" onclick="addTamanho()" class="btn btn-link p-0 text-primary">+ Adicionar linha</button>
                </div>
            </div>
        </div>

        <button class="btn btn-primary mt-3">Salvar alterações</button>
    </form>
</div>

<style>
    .thumb { width: 64px; height: 64px; }
    .thumb-img { max-width: 100%; max-height: 100%; object-fit: cover; }
</style>
<script>
    function reindexImages(wrapper) {
        const rows = Array.from(wrapper.querySelectorAll('.imagem-row'));
        rows.forEach((row, idx) => {
            const radio = row.querySelector('input[type="radio"][name="imagens_principal"]');
            if (radio) radio.value = idx;
        });
        if (!rows.some(r => r.querySelector('input[type="radio"][name="imagens_principal"]')?.checked) && rows[0]) {
            const firstRadio = rows[0].querySelector('input[type="radio"][name="imagens_principal"]');
            if (firstRadio) firstRadio.checked = true;
        }
    }
    function addImagem() {
        const wrapper = document.getElementById('imagens-wrapper');
        const div = document.createElement('div');
        div.className = 'd-flex gap-2 align-items-center imagem-row';
        div.innerHTML = `<input class="form-control" name="imagens_url[]" placeholder="URL da imagem" data-url-preview-source oninput="updateUrlPreview(this)">
                         <input class="form-control" name="imagens_alt[]" placeholder="ALT">
                         <label class="form-check form-check-inline small mb-0"><input class="form-check-input" type="radio" name="imagens_principal" value="0"> Principal</label>
                         <div class="thumb bg-light rounded d-flex align-items-center justify-content-center overflow-hidden">
                             <img data-url-preview class="thumb-img d-none" alt="">
                         </div>
                         <div class="d-flex flex-column gap-1 small">
                            <button type="button" class="btn btn-link p-0 text-primary" onclick="moveImage(this, 'up')">↑</button>
                            <button type="button" class="btn btn-link p-0 text-primary" onclick="moveImage(this, 'down')">↓</button>
                            <button type="button" class="btn btn-link p-0 text-danger" onclick="removeImage(this)">x</button>
                         </div>`;
        wrapper.appendChild(div);
        reindexImages(wrapper);
    }
    function addTamanho() {
        const wrapper = document.getElementById('tamanhos-wrapper');
        const div = document.createElement('div');
        div.className = 'row g-2';
        div.innerHTML = `<div class="col-4"><input class="form-control" name="tamanho_nome[]" placeholder="P/M/G"></div>
                         <div class="col-4"><input class="form-control" name="tamanho_preco[]" type="number" step="0.01" placeholder="Preço"></div>
                         <div class="col-4"><input class="form-control" name="tamanho_estoque[]" type="number" placeholder="Estoque"></div>`;
        wrapper.appendChild(div);
    }
    function updateUrlPreview(input) {
        const row = input.closest('.imagem-row');
        const preview = row?.querySelector('[data-url-preview]');
        if (!preview) return;
        const url = input.value.trim();
        if (url) {
            preview.src = url;
            preview.classList.remove('d-none');
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    }
    function bindFilePreview(inputId, previewId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        if (!input || !preview) return;
        input.addEventListener('change', () => {
            preview.innerHTML = '';
            Array.from(input.files || []).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const img = document.createElement('img');
                img.className = 'thumb thumb-img border rounded';
                img.alt = file.name;
                preview.appendChild(img);
                const reader = new FileReader();
                reader.onload = e => img.src = e.target?.result;
                reader.readAsDataURL(file);
            });
        });
    }
    function moveImage(button, direction) {
        const row = button.closest('.imagem-row');
        const wrapper = row?.parentElement;
        if (!row || !wrapper) return;
        if (direction === 'up' && row.previousElementSibling) {
            wrapper.insertBefore(row, row.previousElementSibling);
        } else if (direction === 'down' && row.nextElementSibling) {
            wrapper.insertBefore(row.nextElementSibling, row);
        }
        reindexImages(wrapper);
    }
    function removeImage(button) {
        const row = button.closest('.imagem-row');
        const wrapper = row?.parentElement;
        if (!row || !wrapper) return;
        row.remove();
        reindexImages(wrapper);
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-url-preview-source]').forEach(el => updateUrlPreview(el));
        const wrapper = document.getElementById('imagens-wrapper');
        if (wrapper) reindexImages(wrapper);
        bindFilePreview('upload-editar', 'upload-preview-editar');
    });
</script>
@endsection
