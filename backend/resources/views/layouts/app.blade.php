<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Loja mobile-first de camisas de futebol.">
    <title>{{ config('app.name') }} - @yield('title', 'Camisas de futebol')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-[Montserrat] antialiased">
    <div class="min-h-screen flex flex-col">
        <x-navbar />

        <main class="flex-1">
            @yield('content')
        </main>

        <x-footer />
    </div>

    <div id="toast-container" class="fixed top-3 right-3 space-y-2 z-40"></div>
    <a href="https://wa.me/5511988887777?text=Oi%2C%20gostaria%20de%20saber%20mais%20sobre%20as%20camisas" target="_blank" rel="noreferrer" class="fixed bottom-4 right-4 z-40 bg-[#25D366] text-white rounded-full shadow-lg w-14 h-14 flex items-center justify-center hover:brightness-110 transition">
        <i class="fa-brands fa-whatsapp text-3xl"></i>
    </a>
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
