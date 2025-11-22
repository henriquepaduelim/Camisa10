<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $cupons = Coupon::latest()->get();
        return view('admin.coupons', compact('cupons'));
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

    public function destroy(Coupon $cupom)
    {
        $cupom->delete();
        return back()->with('success', 'Cupom removido.');
    }
}
