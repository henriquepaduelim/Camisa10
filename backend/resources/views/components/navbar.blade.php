<header class="bg-white shadow-sm sticky top-0 z-30">
    <div class="mx-auto max-w-6xl px-4 py-3 flex items-center justify-between gap-3">
            <a href="/" class="flex items-center gap-2 text-brand font-bold text-lg">
                <i class="fa-solid fa-futbol text-xl"></i>
                <span>{{ config('app.name') }}</span>
            </a>

        <form action="/produtos" method="GET" class="hidden sm:flex flex-1 max-w-md">
            <label class="sr-only" for="busca">Buscar</label>
            <div class="flex w-full gap-2">
                <input id="busca" name="q" type="search" placeholder="Buscar camisas, clubes, ligas..." class="w-full rounded-full border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" />
                <button class="bg-cyan-600 text-white rounded-full px-4 text-sm font-semibold hover:bg-cyan-700 transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>

        <nav class="flex items-center gap-3 text-slate-700">
            <a href="/" class="flex flex-col items-center text-xs sm:hidden">
                <i class="fa-solid fa-house text-lg"></i>
                Home
            </a>
            <a href="/produtos" class="flex flex-col items-center text-xs sm:hidden">
                <i class="fa-solid fa-shirt text-lg"></i>
                Loja
            </a>
            <a href="/carrinho" class="relative flex flex-col items-center text-xs text-slate-800">
                <i class="fa-solid fa-basket-shopping text-lg" aria-hidden="true"></i>
                <span class="sr-only">Carrinho</span>
                @if(($cartCount ?? 0) > 0)
                    <span class="absolute -top-2 -right-3 bg-amber-500 text-white text-[11px] font-bold rounded-full px-2 py-0.5">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
            @auth
                <a href="/conta" class="hidden sm:flex items-center gap-2 text-sm font-semibold btn btn-primary px-4 py-2 rounded-full">
                    <i class="fa-solid fa-user"></i>
                    {{ \Illuminate\Support\Str::limit(auth()->user()->name, 10) }}
                </a>
            @else
                <a href="/login" class="hidden sm:flex items-center gap-2 text-sm font-semibold btn btn-primary px-4 py-2 rounded-full">
                    <i class="fa-solid fa-user"></i>
                    Entrar
                </a>
            @endauth
        </nav>
    </div>

    <div class="sm:hidden px-4 pb-3">
        <form action="/produtos" method="GET">
            <label class="sr-only" for="busca-mobile">Buscar</label>
            <div class="flex gap-2">
                <input id="busca-mobile" name="q" type="search" placeholder="Buscar camisas..." class="w-full rounded-full border border-slate-200 px-4 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" />
                <button class="bg-cyan-600 text-white rounded-full px-4 text-sm font-semibold hover:bg-cyan-700 transition">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>
    </div>
</header>
