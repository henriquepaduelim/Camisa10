<?php

namespace App\Services\Payments;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PagarmeGateway
{
    public function __construct(private ?Client $client = null)
    {
        $this->client = $client ?? new Client([
            'base_uri' => config('payment.pagarme_base', 'https://api.pagar.me/core/v5/'),
            'timeout' => 10,
        ]);
    }

    /**
     * Processa pagamento usando Pagar.me (exemplo com PIX).
     */
    public function processar(float $valor, string $metodo, array $meta = []): string
    {
        $apiKey = config('payment.pagarme_key');
        if (!$apiKey) {
            throw new \RuntimeException('PAGARME_API_KEY não configurada.');
        }

        // Apenas PIX implementado neste exemplo
        if ($metodo !== 'pix') {
            throw new \InvalidArgumentException('Método de pagamento não suportado: ' . $metodo);
        }

        $payload = [
            'items' => [
                [
                    'name' => $meta['descricao'] ?? 'Pedido Gallo Classics',
                    'quantity' => 1,
                    'amount' => (int) round($valor * 100), // em centavos
                ],
            ],
            'customer' => [
                'name' => $meta['cliente_nome'] ?? 'Cliente',
                'email' => $meta['cliente_email'] ?? 'cliente@example.com',
                'type' => 'individual',
            ],
            'charges' => [
                [
                    'payment_method' => 'pix',
                    'amount' => (int) round($valor * 100),
                    'pix' => [
                        'expires_in' => 3600,
                    ],
                ],
            ],
        ];

        $response = $this->client->post('orders', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($apiKey . ':'),
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        $data = json_decode((string) $response->getBody(), true);
        $status = $data['status'] ?? 'failed';

        // Mapeia status Pagar.me para status interno
        return match ($status) {
            'paid' => 'pago',
            'processing', 'waiting_payment' => 'aguardando',
            default => 'falhou',
        };
    }
}
