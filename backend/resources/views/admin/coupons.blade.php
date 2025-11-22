@extends('admin.layout')

@section('title', 'Cupons')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card p-4">
        <h2 class="font-semibold mb-3">Novo cupom</h2>
        <form method="POST" action="{{ route('admin.cupons.store') }}" class="space-y-2" data-loading>
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <input class="input" name="codigo" placeholder="CODIGO10" required>
                <select class="input" name="tipo">
                    <option value="percentual">Percentual</option>
                    <option value="fixo">Fixo</option>
                </select>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                <input class="input" name="valor" type="number" step="0.01" placeholder="Valor" required>
                <input class="input" name="valor_minimo" type="number" step="0.01" placeholder="Valor mínimo">
                <input class="input" name="limite_uso" type="number" placeholder="Limite de uso">
            </div>
            <input class="input" name="expira_em" type="date">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="ativo" value="1" checked> Ativo</label>
            <button class="btn btn-primary w-full">Salvar</button>
        </form>
    </div>

    <div class="card p-4 overflow-auto">
        <h2 class="font-semibold mb-3">Cupons</h2>
        <table class="w-full text-sm">
            <thead><tr class="text-left text-slate-600"><th>Código</th><th>Tipo</th><th>Valor</th><th>Ativo</th><th>Ações</th></tr></thead>
            <tbody class="divide-y">
                @foreach($cupons as $c)
                    <tr>
                        <td class="py-2 font-semibold">{{ $c->codigo }}</td>
                        <td class="py-2">{{ $c->tipo }}</td>
                        <td class="py-2">{{ $c->valor }}</td>
                        <td class="py-2 text-xs">{{ $c->ativo ? 'Sim' : 'Não' }}</td>
                        <td class="py-2">
                            <form method="POST" action="{{ route('admin.cupons.update', $c) }}" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="codigo" value="{{ $c->codigo }}">
                                <input type="hidden" name="tipo" value="{{ $c->tipo }}">
                                <input type="hidden" name="valor" value="{{ $c->valor }}">
                                <input type="hidden" name="valor_minimo" value="{{ $c->valor_minimo }}">
                                <input type="hidden" name="limite_uso" value="{{ $c->limite_uso }}">
                                <input type="hidden" name="expira_em" value="{{ optional($c->expira_em)->format('Y-m-d') }}">
                                <input type="hidden" name="ativo" value="{{ $c->ativo ? 0 : 1 }}">
                                <button class="text-xs text-cyan-700 font-semibold">Toggle ativo</button>
                            </form>
                            <form method="POST" action="{{ route('admin.cupons.destroy', $c) }}" class="inline" onsubmit="return confirm('Remover?')">
                                @csrf @method('DELETE')
                                <button class="text-xs text-red-600 font-semibold ml-2">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>.input { @apply w-full rounded-xl border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-cyan-500 focus:outline-none; }</style>
@endsection
