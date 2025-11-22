@extends('layouts.app')

@section('title', 'Contato')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-10 space-y-6">
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h1 class="text-2xl font-bold">Fale conosco</h1>
        <p class="text-slate-700 text-sm sm:text-base">Dúvidas sobre pedidos, tamanhos ou entregas? Envie sua mensagem e responderemos em breve.</p>
        <form class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <input class="input" placeholder="Nome completo" required>
                <input class="input" type="email" placeholder="E-mail" required>
            </div>
            <input class="input" placeholder="Assunto" required>
            <textarea class="input min-h-[140px]" placeholder="Mensagem" required></textarea>
            <button type="submit" class="btn btn-primary">Enviar mensagem</button>
        </form>
        <div class="border-t border-slate-200 pt-4 text-sm text-slate-700 space-y-2">
            <div><i class="fa-solid fa-envelope mr-2"></i>contato@galloclassics.test</div>
            <div><i class="fa-solid fa-phone mr-2"></i>(11) 98888-7777</div>
            <div><i class="fa-solid fa-location-dot mr-2"></i>São Paulo - SP</div>
        </div>
    </div>
</section>
@endsection
