<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private CheckoutService $checkoutService
    ) {
    }

    public function __invoke(CheckoutRequest $request)
    {
        $cart = $this->cartService->getCart($request->user());
        $dados = $request->validated();

        $order = $this->checkoutService->checkout(
            $cart,
            $dados['cliente'],
            $dados['endereco'],
            $dados['pagamento']['metodo']
        );

        return response()->json(['data' => $order], 201);
    }
}
