<?php

namespace App\Services;

class PaymentService
{
    /**
     * Mock de pagamento. Retorna "pago" sempre que valor > 0.
     */
    public function processar(float $valor, string $metodo): string
    {
        // Ponto de extensão: integrar gateway real implementando esta interface.
        if ($valor <= 0) {
            return 'falhou';
        }

        return 'pago';
    }
}
