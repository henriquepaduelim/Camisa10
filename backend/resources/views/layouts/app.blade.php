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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-T2kGsiV3ZsXetjX8VJQ0mgPqHJ7MB4kW2TbQQy5MfONiMvz48+/AWTRERkUd49nO/5cHZWFyVKP1glN6xGUjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-[Montserrat] antialiased">
    <div class="min-h-screen flex flex-col">
        <x-navbar />

        <main class="flex-1">
            @if(session('success'))
                <div class="max-w-6xl mx-auto px-4 pt-4">
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            @if($errors->any())
                <div class="max-w-6xl mx-auto px-4 pt-4">
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl space-y-1">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif
            @yield('content')
        </main>

        <x-footer />
    </div>
</body>
</html>
