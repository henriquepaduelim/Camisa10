@props(['produto'])
<article class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
    <a href="{{ url('/produtos/' . $produto->slug) }}" class="block">
        <div class="relative">
            <img src="{{ $produto->images->first()?->url ?? 'https://via.placeholder.com/600x600?text=Camisa' }}" alt="Imagem de {{ $produto->nome }}" class="w-full aspect-[4/5] object-cover">
            @if($produto->preco_promocional)
                <span class="absolute top-3 left-3 bg-amber-500 text-white text-xs font-semibold px-2 py-1 rounded-full">Oferta</span>
            @endif
        </div>
    </a>
    <div class="p-4 flex-1 flex flex-col gap-2">
        <div class="text-xs uppercase tracking-wide text-slate-500">{{ $produto->club?->nome ?? $produto->league?->nome }}</div>
        <h3 class="font-semibold text-base leading-tight">{{ $produto->nome }}</h3>
        <div class="mt-auto">
            <div class="flex items-center gap-2">
                <span class="text-lg font-bold text-slate-900">R$ {{ number_format($produto->preco_promocional ?? $produto->preco, 2, ',', '.') }}</span>
                @if($produto->preco_promocional)
                    <span class="text-sm line-through text-slate-400">R$ {{ number_format($produto->preco, 2, ',', '.') }}</span>
                @endif
            </div>
            @php $sizes = $produto->sizes ?? collect(); @endphp
            <form method="POST" action="/carrinho" class="mt-3 space-y-2" data-loading>
                @csrf
                <input type="hidden" name="product_id" value="{{ $produto->id }}">
                <input type="hidden" name="quantidade" value="1">

                @if($sizes->count() > 1)
                    <label class="text-xs font-semibold text-slate-600">Tamanho</label>
                    <select name="product_size_id" required class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-[var(--cor-primaria)] focus:outline-none">
                        <option value="">Selecione</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->tamanho }}</option>
                        @endforeach
                    </select>
                @elseif($sizes->count() === 1)
                    <input type="hidden" name="product_size_id" value="{{ $sizes->first()->id }}">
                @endif

                <button data-loading-text="Adicionando..." class="btn btn-primary w-full text-sm py-2 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-cart-plus"></i>
                    Adicionar ao carrinho
                </button>
            </form>
        </div>
    </div>
</article>
