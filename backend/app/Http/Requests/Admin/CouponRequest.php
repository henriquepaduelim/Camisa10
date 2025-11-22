<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $id = $this->route('cupom')?->id ?? null;

        return [
            'codigo' => 'required|string|max:50|unique:coupons,codigo,' . $id,
            'tipo' => 'required|in:percentual,fixo',
            'valor' => 'required|numeric|min:0',
            'valor_minimo' => 'nullable|numeric|min:0',
            'limite_uso' => 'nullable|integer|min:1',
            'expira_em' => 'nullable|date',
            'ativo' => 'boolean',
        ];
    }
}
