@extends('admin.layout')

@section('title', 'Produtos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-0">Produtos</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Produtos</li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card p-4">
        <h2 class="font-semibold mb-3 h5">Novo produto</h2>
        <form method="POST" action="{{ route('admin.produtos.store') }}" class="mb-3" data-loading enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-sm-6">
                    <input class="form-control" name="nome" placeholder="Nome" required data-slug-source data-slug-target="#novo-slug">
                </div>
                <div class="col-sm-6">
                    <input class="form-control" id="novo-slug" name="slug" placeholder="slug-exemplo" required>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="preco" type="number" step="0.01" placeholder="Preço" required>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" name="preco_promocional" type="number" step="0.01" placeholder="Preço promocional">
                </div>
            </div>
            <div class="row g-3">
                <div class="col-sm-4">
                    <select class="form-control" name="category_id">
                        <option value="">Categoria</option>
                        @foreach($categorias as $c)
                            <option value="{{ $c->id }}">{{ $c->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <select class="form-control" name="club_id">
                        <option value="">Clube</option>
                        @foreach($clubes as $c)
                            <option value="{{ $c->id }}">{{ $c->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-4">
                    <select class="form-control" name="league_id">
                        <option value="">Liga</option>
                        @foreach($ligas as $l)
                            <option value="{{ $l->id }}">{{ $l->nome }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3 small">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo-novo" checked>
                    <label class="form-check-label" for="ativo-novo">Ativo</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="destaque" value="1" id="destaque-novo">
                    <label class="form-check-label" for="destaque-novo">Destaque</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="hero" value="1" id="hero-novo">
                    <label class="form-check-label" for="hero-novo">Hero</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="mais_vendido" value="1" id="maisvendido-novo">
                    <label class="form-check-label" for="maisvendido-novo">Mais vendido</label>
                </div>
            </div>
            <div class="col-sm-4">
                <label class="form-label">Ordem no hero (1-10)</label>
                <input class="form-control" name="hero_order" type="number" min="1" max="10" placeholder="Ex.: 1">
                <div class="form-text">Use para ordenar os itens do carrossel (máx. 3 marcados).</div>
            </div>

            <div>
                <label class="form-label">Descrição</label>
                <textarea class="form-control" name="descricao" rows="3" placeholder="Detalhes do produto"></textarea>
            </div>
            <div class="row g-3">
                <div class="col-sm-6">
                    <label class="form-label">Descrição curta</label>
                    <input class="form-control" name="descricao_curta" placeholder="Resumo curto">
                </div>
                <div class="col-sm-6">
                    <label class="form-label">Meta title</label>
                    <input class="form-control" name="meta_title" placeholder="SEO title">
                </div>
            </div>
            <div>
                <label class="form-label">Meta description</label>
                <textarea class="form-control" name="meta_description" rows="2" placeholder="SEO description"></textarea>
            </div>

            <div class="row g-3">
                <div class="col-lg-6">
                        <div class="card p-3">
                        <h3 class="h6 fw-semibold">Imagens</h3>
                        <div id="imagens-wrapper" class="space-y-2">
                            <div class="d-flex gap-2 align-items-center imagem-row">
                                <input class="form-control" name="imagens_url[]" placeholder="URL da imagem" data-url-preview-source oninput="updateUrlPreview(this)">
                                <input class="form-control" name="imagens_alt[]" placeholder="ALT">
                                <label class="form-check form-check-inline small mb-0">
                                    <input class="form-check-input" type="radio" name="imagens_principal" value="0" checked> Principal
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
                        <div class="mb-2">
                            <label class="form-label">Upload de imagens</label>
                            <input type="file" id="upload-novo" name="imagens_upload[]" multiple class="form-control form-control-sm">
                            <div id="upload-preview-novo" class="d-flex gap-2 flex-wrap"></div>
                            <p class="form-text">.jpg/.png até 2 MB cada.</p>
                        </div>
                        <button type="button" onclick="addImagem()" class="btn btn-link p-0 text-primary">+ Adicionar linha</button>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card p-3">
                        <h3 class="h6 fw-semibold">Tamanhos</h3>
                        <div id="tamanhos-wrapper" class="d-flex flex-column gap-2">
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

            <button class="btn btn-primary w-100">Salvar</button>
        </form>
    </div>
    </div>

    <div class="col-lg-6">
        <div class="card p-4 overflow-auto space-y-3">
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                <h2 class="font-semibold h5 mb-0">Produtos</h2>
                <form method="GET" class="w-100 w-sm-auto d-flex flex-column flex-sm-row gap-2">
                    <input class="form-control form-control-sm" style="max-width: 180px" name="q" value="{{ $filtros['q'] ?? '' }}" placeholder="Buscar nome ou slug">
                    <select class="form-control form-control-sm" name="status" style="max-width: 140px">
                        <option value="">Status</option>
                        <option value="ativo" @selected(($filtros['status'] ?? '')==='ativo')>Ativo</option>
                        <option value="inativo" @selected(($filtros['status'] ?? '')==='inativo')>Inativo</option>
                    </select>
                    <select class="form-control form-control-sm" name="category_id" style="max-width: 140px">
                        <option value="">Categoria</option>
                        @foreach($categorias as $c)
                            <option value="{{ $c->id }}" @selected(($filtros['category_id'] ?? '')==$c->id)>{{ $c->nome }}</option>
                        @endforeach
                    </select>
                    <select class="form-control form-control-sm" name="club_id" style="max-width: 140px">
                        <option value="">Clube</option>
                        @foreach($clubes as $c)
                            <option value="{{ $c->id }}" @selected(($filtros['club_id'] ?? '')==$c->id)>{{ $c->nome }}</option>
                        @endforeach
                    </select>
                    <select class="form-control form-control-sm" name="league_id" style="max-width: 140px">
                        <option value="">Liga</option>
                        @foreach($ligas as $l)
                            <option value="{{ $l->id }}" @selected(($filtros['league_id'] ?? '')==$l->id)>{{ $l->nome }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary btn-sm w-100 w-sm-auto">Filtrar</button>
                </form>
            </div>
            <table class="table table-sm align-middle">
                <thead>
                    <tr class="text-muted">
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produtos as $p)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $p->nome }}</div>
                                <div class="text-muted small">{{ $p->slug }}</div>
                            </td>
                            <td>R$ {{ number_format($p->preco, 2, ',', '.') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.produtos.status', $p) }}" class="d-inline" data-loading>
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="ativo" value="{{ $p->ativo ? 0 : 1 }}">
                                    <button class="btn btn-link p-0 fw-semibold {{ $p->ativo ? 'text-primary' : 'text-muted' }}">
                                        {{ $p->ativo ? 'Ativo' : 'Inativo' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-link btn-sm text-primary" href="{{ route('admin.produtos.edit', $p) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.produtos.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Remover?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-link btn-sm text-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-2">
                {{ $produtos->links() }}
            </div>
        </div>
    </div>
    </div>
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
        div.className = 'flex gap-2 items-center imagem-row';
        div.innerHTML = `<input class="input" name="imagens_url[]" placeholder="URL da imagem" data-url-preview-source oninput="updateUrlPreview(this)">
                         <input class="input" name="imagens_alt[]" placeholder="ALT">
                         <label class="flex items-center gap-1 text-xs"><input type="radio" name="imagens_principal" value="0"> Principal</label>
                         <div class="w-16 h-16 bg-slate-100 rounded overflow-hidden flex items-center justify-center">
                            <img data-url-preview class="max-h-16" alt="">
                         </div>
                         <div class="flex flex-col gap-1 text-[11px]">
                            <button type="button" class="text-brand hover:underline" onclick="moveImage(this, 'up')">↑</button>
                            <button type="button" class="text-brand hover:underline" onclick="moveImage(this, 'down')">↓</button>
                            <button type="button" class="text-red-600 hover:underline" onclick="removeImage(this)">x</button>
                         </div>`;
        wrapper.appendChild(div);
        reindexImages(wrapper);
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
        bindFilePreview('upload-novo', 'upload-preview-novo');
        const wrapper = document.getElementById('imagens-wrapper');
        if (wrapper) reindexImages(wrapper);
    });
</script>
@endsection
