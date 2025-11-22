@extends('admin.layout')

@section('title', 'Pedidos')

@section('content')
<div class="card p-4 overflow-auto">
    <h2 class="font-semibold mb-3">Pedidos</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-slate-600">
                <th>ID</th>
                <th>Cliente</th>
                <th>Status</th>
                <th>Total</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($pedidos as $p)
                <tr>
                    <td class="py-2">#{{ $p->id }}</td>
                    <td class="py-2">{{ $p->user?->name ?? 'Guest' }}</td>
                    <td class="py-2 text-xs font-semibold text-cyan-700">{{ ucfirst($p->status) }}</td>
                    <td class="py-2">R$ {{ number_format($p->total, 2, ',', '.') }}</td>
                    <td class="py-2">
                        <form method="POST" action="{{ route('admin.pedidos.status', $p) }}" class="flex items-center gap-2" data-loading>
                            @csrf @method('PATCH')
                            <select name="status" class="input text-sm">
                                @foreach(['pendente','pago','enviado','entregue','cancelado'] as $status)
                                    <option value="{{ $status }}" @selected($p->status === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="comentario" value="Atualizado via painel">
                            <button class="btn btn-primary text-xs">Atualizar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3">{{ $pedidos->links() }}</div>
</div>

<style>.input { @apply w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none; } .btn { @apply inline-flex items-center justify-center gap-2 px-3 py-2 rounded-lg font-semibold transition; } .btn-primary { @apply bg-cyan-600 text-white hover:bg-cyan-700; }</style>
@endsection
