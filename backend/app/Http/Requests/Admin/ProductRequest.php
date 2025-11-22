<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $id = $this->route('produto')?->id ?? null;

        return [
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|min:0',
            'moeda' => 'required|string|max:5',
            'category_id' => 'nullable|exists:categories,id',
            'club_id' => 'nullable|exists:clubs,id',
            'league_id' => 'nullable|exists:leagues,id',
            'ativo' => 'boolean',
            'destaque' => 'boolean',
            'mais_vendido' => 'boolean',
            'lancamento' => 'boolean',
            'sku' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'estoque_total' => 'nullable|integer|min:0',
            'imagens' => 'nullable|array',
            'imagens.*.url' => 'required_with:imagens|string',
            'imagens.*.alt' => 'nullable|string',
            'imagens.*.principal' => 'boolean',
            'imagens.*.ordem' => 'integer',
            'tamanhos' => 'nullable|array',
            'tamanhos.*.tamanho' => 'required_with:tamanhos|string|max:10',
            'tamanhos.*.sku' => 'nullable|string|max:100',
            'tamanhos.*.preco' => 'nullable|numeric|min:0',
            'tamanhos.*.estoque' => 'nullable|integer|min:0',
        ];
    }
}
