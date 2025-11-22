@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<section class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Finalizar compra</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-4">
            <div class="bg-white border border-slate-100 rounded-xl p-4 space-y-3">
                <h2 class="font-semibold text-lg flex items-center gap-2"><i class="fa-solid fa-user text-cyan-600"></i> Dados pessoais</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="Nome completo" />
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="E-mail" />
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="Telefone" />
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-xl p-4 space-y-3">
                <h2 class="font-semibold text-lg flex items-center gap-2"><i class="fa-solid fa-location-dot text-cyan-600"></i> Endereço de entrega</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="CEP" />
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="Rua" />
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="Número" />
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="Complemento" />
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="Bairro" />
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="Cidade" />
                    <input class="w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none" placeholder="Estado" />
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-xl p-4 space-y-3">
                <h2 class="font-semibold text-lg flex items-center gap-2"><i class="fa-solid fa-credit-card text-cyan-600"></i> Pagamento</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-center gap-2 border rounded-xl px-3 py-2 cursor-pointer">
                        <input type="radio" name="pagamento" class="accent-cyan-600" checked>
                        <span>Cartão (mock)</span>
                    </label>
                    <label class="flex items-center gap-2 border rounded-xl px-3 py-2 cursor-pointer">
                        <input type="radio" name="pagamento" class="accent-cyan-600">
                        <span>PIX (mock)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-100 rounded-xl p-4 space-y-3 h-fit">
            <h2 class="font-semibold text-lg">Resumo</h2>
            <div class="space-y-2 text-sm">
                @foreach($cart->items as $item)
                    <div class="flex justify-between">
                        <span>{{ $item->product->nome }} ({{ $item->quantidade }}x)</span>
                        <span>R$ {{ number_format($item->total, 2, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between text-sm">
                <span>Subtotal</span>
                <span>R$ {{ number_format($cart->subtotal, 2, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm text-emerald-600">
                <span>Descontos</span>
                <span>- R$ {{ number_format($cart->desconto, 2, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-base font-bold border-t pt-3">
                <span>Total</span>
                <span>R$ {{ number_format($cart->total, 2, ',', '.') }}</span>
            </div>
            <button class="w-full bg-cyan-600 text-white font-semibold px-4 py-3 rounded-full hover:bg-cyan-700 transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-shield-halved"></i> Confirmar pedido
            </button>
        </div>
    </div>
</section>
@endsection
