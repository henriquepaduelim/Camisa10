<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function __construct(private PaymentService $payment) {}

    public function checkout(Cart $cart, array $dadosCliente, array $enderecoDados, string $metodoPagamento): Order
    {
        if ($cart->items()->count() === 0) {
            throw ValidationException::withMessages(['carrinho' => 'Carrinho vazio.']);
        }

        return DB::transaction(function () use ($cart, $dadosCliente, $enderecoDados, $metodoPagamento) {
            $address = $this->upsertAddress($cart, $enderecoDados);
            $total = $cart->total;
            $pagamentoStatus = $this->payment->processar($total, $metodoPagamento, [
                'cliente_nome' => $dadosCliente['nome'] ?? null,
                'cliente_email' => $dadosCliente['email'] ?? null,
                'descricao' => 'Pedido #' . uniqid(),
            ]);

            $order = Order::create([
                'user_id' => $cart->user_id,
                'cart_id' => $cart->id,
                'address_id' => $address?->id,
                'coupon_id' => $cart->coupon_id,
                'status' => $pagamentoStatus === 'pago' ? 'pago' : 'pendente',
                'pagamento_status' => $pagamentoStatus,
                'pagamento_metodo' => $metodoPagamento,
                'subtotal' => $cart->subtotal,
                'desconto' => $cart->desconto,
                'frete' => 0,
                'total' => $cart->total,
                'observacoes' => $dadosCliente['observacoes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'nome' => $item->product->nome,
                    'tamanho' => $item->size?->tamanho,
                    'quantidade' => $item->quantidade,
                    'preco_unitario' => $item->preco_unitario,
                    'total' => $item->total,
                ]);
            }

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $order->status,
                'comentario' => 'Pedido criado',
            ]);

            $cart->update(['status' => 'convertido']);

            return $order->load('items', 'address', 'coupon');
        });
    }

    protected function upsertAddress(Cart $cart, array $data): ?Address
    {
        if (!$cart->user_id) {
            return null;
        }

        return Address::updateOrCreate(
            ['user_id' => $cart->user_id, 'apelido' => $data['apelido'] ?? 'Principal'],
            [
                'nome' => $data['nome'],
                'telefone' => $data['telefone'] ?? null,
                'cep' => $data['cep'],
                'rua' => $data['rua'],
                'numero' => $data['numero'] ?? null,
                'complemento' => $data['complemento'] ?? null,
                'bairro' => $data['bairro'] ?? null,
                'cidade' => $data['cidade'],
                'estado' => $data['estado'],
                'pais' => $data['pais'] ?? 'Brasil',
            ]
        );
    }
}
