<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-T2kGsiV3ZsXetjX8VJQ0mgPqHJ7MB4kW2TbQQy5MfONiMvz48+/AWTRERkUd49nO/5cHZWFyVKP1glN6xGUjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-[Montserrat] antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 w-full max-w-md">
            <div class="flex items-center gap-2 text-cyan-700 font-bold text-lg mb-4">
                <i class="fa-solid fa-gauge-high"></i> Painel Admin
            </div>
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
            <form method="POST" action="/admin/login" class="space-y-3" data-loading>
                @csrf
                <div>
                    <label class="text-sm font-semibold text-slate-700" for="email">E-mail</label>
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" type="email" name="email" id="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700" for="password">Senha</label>
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" type="password" name="password" id="password" required>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="accent-cyan-600">
                    <label for="remember" class="text-sm text-slate-600">Lembrar-me</label>
                </div>
                <button data-loading-text="Entrando..." class="w-full bg-cyan-600 text-white font-semibold px-4 py-3 rounded-full hover:bg-cyan-700 transition">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
