<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddItemRequest;
use App\Http\Requests\Cart\UpdateItemRequest;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function show(Request $request)
    {
        $cart = $this->cartService->getCart($request->user());
        return response()->json(['data' => $cart]);
    }

    public function store(AddItemRequest $request)
    {
        $cart = $this->cartService->getCart($request->user());
        $cart = $this->cartService->addItem(
            $cart,
            $request->integer('product_id'),
            $request->input('product_size_id'),
            $request->integer('quantidade')
        );

        return response()->json(['data' => $cart], 201);
    }

    public function update(UpdateItemRequest $request, CartItem $item)
    {
        $cart = $this->cartService->getCart($request->user());
        $cart = $this->cartService->updateItem($cart, $item, $request->integer('quantidade'));

        return response()->json(['data' => $cart]);
    }

    public function destroy(Request $request, CartItem $item)
    {
        $cart = $this->cartService->getCart($request->user());
        $cart = $this->cartService->removeItem($cart, $item);

        return response()->json(['data' => $cart]);
    }

    public function aplicarCupom(Request $request)
    {
        $request->validate(['codigo' => 'required|string']);
        $cart = $this->cartService->getCart($request->user());
        $cart = $this->cartService->applyCoupon($cart, $request->input('codigo'));

        return response()->json(['data' => $cart]);
    }
}
