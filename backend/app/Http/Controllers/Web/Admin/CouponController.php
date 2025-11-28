<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::query()->latest();

        if ($search = $request->input('q')) {
            $query->where('codigo', 'like', '%' . $search . '%');
        }

        if ($status = $request->input('ativo')) {
            if ($status === '1') {
                $query->where('ativo', true);
            } elseif ($status === '0') {
                $query->where('ativo', false);
            }
        }

        if ($expiracao = $request->input('expirado')) {
            if ($expiracao === 'sim') {
                $query->whereNotNull('expira_em')->where('expira_em', '<', now());
            } elseif ($expiracao === 'nao') {
                $query->where(function ($q) {
                    $q->whereNull('expira_em')->orWhere('expira_em', '>=', now());
                });
            }
        }

        $cupons = $query->paginate(20)->withQueryString();

        return view('admin.coupons', [
            'cupons' => $cupons,
            'filtros' => $request->only(['q', 'ativo', 'expirado']),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:50|unique:coupons,codigo',
            'tipo' => 'required|in:percentual,fixo',
            'valor' => 'required|numeric|min:0',
            'valor_minimo' => 'nullable|numeric|min:0',
            'limite_uso' => 'nullable|integer|min:1',
            'expira_em' => 'nullable|date',
            'ativo' => 'nullable|boolean',
        ]);
        Coupon::create($data + ['ativo' => $request->boolean('ativo')]);
        return back()->with('success', 'Cupom criado.');
    }

    public function update(Request $request, Coupon $cupom)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:50|unique:coupons,codigo,' . $cupom->id,
            'tipo' => 'required|in:percentual,fixo',
            'valor' => 'required|numeric|min:0',
            'valor_minimo' => 'nullable|numeric|min:0',
            'limite_uso' => 'nullable|integer|min:1',
            'expira_em' => 'nullable|date',
            'ativo' => 'nullable|boolean',
        ]);
        $cupom->update($data + ['ativo' => $request->boolean('ativo')]);
        return back()->with('success', 'Cupom atualizado.');
    }

    public function toggleAtivo(Coupon $cupom)
    {
        $cupom->update(['ativo' => !$cupom->ativo]);
        return back()->with('success', 'Status do cupom atualizado.');
    }

    public function destroy(Coupon $cupom)
    {
        $cupom->delete();
        return back()->with('success', 'Cupom removido.');
    }
}
