@extends('layouts.app')

@section('title', 'Minha conta')

@section('content')
<section class="max-w-5xl mx-auto px-4 py-8 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">Olá, {{ $user->name }}</h1>
            <p class="text-sm text-slate-600">{{ $user->email }} @if($user->telefone) • {{ $user->telefone }} @endif</p>
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button class="bg-slate-900 text-white px-4 py-2 rounded-full text-sm font-semibold">Sair</button>
        </form>
    </div>

    <div class="bg-white border border-slate-100 rounded-xl p-5 shadow-sm">
        <h2 class="text-lg font-semibold mb-3">Pedidos</h2>
        @if($user->orders->isEmpty())
            <p class="text-sm text-slate-600">Você ainda não fez pedidos.</p>
        @else
            <div class="space-y-3">
                @foreach($user->orders as $order)
                    <div class="border border-slate-100 rounded-lg p-3">
                        <div class="flex justify-between text-sm">
                            <span>#{{ $order->id }} • {{ $order->created_at->format('d/m/Y') }}</span>
                            <span class="font-semibold text-brand">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="text-sm text-slate-700 mt-1">
                            Total: R$ {{ number_format($order->total, 2, ',', '.') }}
                        </div>
                        <div class="text-sm text-slate-600 mt-1">
                            Itens: {{ $order->items->count() }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
