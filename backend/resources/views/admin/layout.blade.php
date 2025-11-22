<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-T2kGsiV3ZsXetjX8VJQ0mgPqHJ7MB4kW2TbQQy5MfONiMvz48+/AWTRERkUd49nO/5cHZWFyVKP1glN6xGUjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-[Montserrat] antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-slate-900 text-white">
            <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
                <a href="/admin" class="font-bold text-lg flex items-center gap-2">
                    <i class="fa-solid fa-gauge-high"></i> Painel Admin
                </a>
                <nav class="flex gap-4 text-sm">
                    <a href="/admin" class="hover:underline">Dashboard</a>
                    <a href="/admin/produtos" class="hover:underline">Produtos</a>
                    <a href="/admin/taxonomias" class="hover:underline">Taxonomias</a>
                    <a href="/admin/cupons" class="hover:underline">Cupons</a>
                    <a href="/admin/pedidos" class="hover:underline">Pedidos</a>
                    <a href="/admin/configuracoes" class="hover:underline">Configurações</a>
                </nav>
                <form method="POST" action="/admin/logout">
                    @csrf
                    <button class="text-sm bg-white text-slate-900 px-3 py-1 rounded-full font-semibold">Sair</button>
                </form>
            </div>
        </header>

        <main class="flex-1 max-w-6xl mx-auto px-4 py-6">
            @if(session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl space-y-1">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
