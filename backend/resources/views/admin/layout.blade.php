<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-[Montserrat] antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-[var(--cor-primaria-escura)] text-white">
            <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-3 flex-wrap">
                <a href="/admin" class="font-bold text-lg flex items-center gap-2">
                    <i class="fa-solid fa-gauge-high"></i> Painel Admin
                </a>
                <nav class="flex gap-3 text-sm flex-wrap">
                    <a href="/admin" class="hover:underline">Dashboard</a>
                    <a href="/admin/produtos" class="hover:underline">Produtos</a>
                    <a href="/admin/taxonomias" class="hover:underline">Taxonomias</a>
                    <a href="/admin/cupons" class="hover:underline">Cupons</a>
                    <a href="/admin/pedidos" class="hover:underline">Pedidos</a>
                    <a href="/admin/configuracoes" class="hover:underline">Configurações</a>
                </nav>
                <form method="POST" action="/admin/logout" data-loading>
                    @csrf
                    <button data-loading-text="Saindo..." class="text-sm bg-white text-slate-900 px-3 py-1 rounded-full font-semibold">Sair</button>
                </form>
            </div>
        </header>

        <main class="flex-1 max-w-6xl mx-auto px-4 py-6">
            @yield('content')
        </main>
    </div>

    <div id="toast-container" class="fixed top-3 right-3 space-y-2 z-40"></div>
    <script>
        (function() {
            const container = document.getElementById('toast-container');
            const messages = [];
            @if(session('success'))
                messages.push({ type: 'success', text: @json(session('success')) });
            @endif
            @if($errors->any())
                messages.push({ type: 'error', text: @json($errors->all()) });
            @endif
            messages.flat().forEach(msg => {
                const div = document.createElement('div');
                div.className = 'toast ' + (msg.type === 'success' ? 'toast-success' : 'toast-error');
                div.innerText = Array.isArray(msg.text) ? msg.text.join('\n') : msg.text;
                container.appendChild(div);
                setTimeout(() => div.classList.add('toast-hide'), 3000);
                setTimeout(() => div.remove(), 3500);
            });

            document.querySelectorAll('form[data-loading]').forEach(form => {
                form.addEventListener('submit', () => {
                    const btn = form.querySelector('[data-loading-text]');
                    if (btn) {
                        btn.dataset.originalText = btn.innerHTML;
                        btn.innerHTML = btn.dataset.loadingText || 'Enviando...';
                        btn.disabled = true;
                    }
                });
            });
        })();
    </script>
</body>
</html>
