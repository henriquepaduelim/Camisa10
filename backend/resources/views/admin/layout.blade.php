@extends('adminlte::page')

@section('title', 'Painel Admin')

@section('content_header')
    @hasSection('content_header')
        @yield('content_header')
    @else
        <h1>@yield('title', 'Dashboard')</h1>
    @endif
@endsection

@section('content')
    <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;"></div>
    @yield('content')
@endsection

@section('css')
    @vite(['resources/css/app.css'])
@endsection

@section('js')
    @vite(['resources/js/app.js'])
    <script>
        // Toasts Bootstrap para mensagens flash.
        (function() {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const messages = [];
            @if(session('success'))
                messages.push({ type: 'success', text: @json(session('success')) });
            @endif
            @if(session('error'))
                messages.push({ type: 'danger', text: @json(session('error')) });
            @endif
            @if($errors->any())
                messages.push({ type: 'danger', text: @json($errors->all()) });
            @endif
            messages.flat().forEach(msg => {
                const toastEl = document.createElement('div');
                toastEl.className = `toast align-items-center text-bg-${msg.type} border-0`;
                toastEl.role = 'alert';
                toastEl.innerHTML = `<div class="d-flex">
                    <div class="toast-body">${Array.isArray(msg.text) ? msg.text.join('<br>') : msg.text}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>`;
                container.appendChild(toastEl);
                const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
                toast.show();
            });
        })();

        // Botões com data-loading: desabilita e troca texto ao enviar.
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

        // Auto-slug: mantém o slug sincronizado com o nome enquanto o usuário não edita manualmente.
        (function() {
            const slugify = (value) => value
                .toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');

            document.querySelectorAll('[data-slug-source]').forEach(source => {
                const targetSelector = source.dataset.slugTarget;
                if (!targetSelector) return;
                const target = document.querySelector(targetSelector);
                if (!target) return;
                let lastAuto = slugify(source.value || '');

                target.addEventListener('input', () => {
                    if (target.value !== lastAuto) {
                        lastAuto = null; // usuário tomou controle
                    }
                });

                source.addEventListener('input', () => {
                    if (lastAuto !== null && target.value && target.value !== lastAuto) {
                        return;
                    }
                    const next = slugify(source.value || '');
                    target.value = next;
                    lastAuto = next;
                });
            });
        })();
    </script>
@endsection
