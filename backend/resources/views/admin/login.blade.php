<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-[Montserrat] antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-6 w-full max-w-md">
            <div class="flex items-center gap-2 text-brand font-bold text-lg mb-4">
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
                    <input class="field-brand" type="email" name="email" id="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700" for="password">Senha</label>
                    <input class="field-brand" type="password" name="password" id="password" required>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="accent-[var(--cor-primaria)]">
                    <label for="remember" class="text-sm text-slate-600">Lembrar-me</label>
                </div>
                <button data-loading-text="Entrando..." class="w-full btn btn-primary font-semibold px-4 py-3 rounded-full">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
