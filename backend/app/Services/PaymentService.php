<?php

namespace App\Services;

use App\Services\Payments\PagarmeGateway;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function __construct(private PagarmeGateway $pagarmeGateway)
    {
    }

    /**
     * Processa o pagamento via driver configurado.
     */
    public function processar(float $valor, string $metodo, array $meta = []): string
    {
        if ($valor <= 0) {
            return 'falhou';
        }

        $driver = config('payment.provider', 'mock');

        try {
            return match ($driver) {
                'pagarme' => $this->pagarmeGateway->processar($valor, $metodo, $meta),
                default => 'pago',
            };
        } catch (\Throwable $e) {
            Log::error('Erro ao processar pagamento', [
                'driver' => $driver,
                'metodo' => $metodo,
                'erro' => $e->getMessage(),
            ]);
            return 'falhou';
        }
    }
}
