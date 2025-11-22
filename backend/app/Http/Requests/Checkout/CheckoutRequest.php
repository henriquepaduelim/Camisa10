<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente.nome' => 'required|string|max:255',
            'cliente.email' => 'nullable|email',
            'cliente.telefone' => 'nullable|string|max:20',
            'cliente.observacoes' => 'nullable|string|max:1000',
            'endereco.nome' => 'required|string|max:255',
            'endereco.telefone' => 'nullable|string|max:20',
            'endereco.cep' => 'required|string|max:9',
            'endereco.rua' => 'required|string|max:255',
            'endereco.numero' => 'nullable|string|max:20',
            'endereco.complemento' => 'nullable|string|max:255',
            'endereco.bairro' => 'nullable|string|max:255',
            'endereco.cidade' => 'required|string|max:255',
            'endereco.estado' => 'required|string|max:2',
            'endereco.pais' => 'nullable|string|max:100',
            'pagamento.metodo' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório.',
            'email' => 'Informe um e-mail válido.',
        ];
    }
}
