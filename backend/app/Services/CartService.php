<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CartService
{
    public function getCart(?User $user): Cart
    {
        return Cart::firstOrCreate(
            ['user_id' => $user?->id, 'status' => 'aberto'],
            ['subtotal' => 0, 'desconto' => 0, 'total' => 0]
        )->load('items.product', 'items.size');
    }

    public function addItem(Cart $cart, int $productId, ?int $sizeId, int $qty): Cart
    {
        $product = Product::findOrFail($productId);
        $size = $sizeId ? ProductSize::findOrFail($sizeId) : null;

        if ($product->sizes()->exists() && !$size) {
            throw ValidationException::withMessages([
                'product_size_id' => 'Selecione um tamanho para este produto.',
            ]);
        }

        if ($size && $size->product_id !== $product->id) {
            throw ValidationException::withMessages([
                'product_size_id' => 'Tamanho inválido para este produto.',
            ]);
        }

        $price = $size?->preco ?? $product->preco;
        $item = $cart->items()->where('product_id', $productId)->where('product_size_id', $sizeId)->first();

        if ($item) {
            $item->quantidade += $qty;
            $item->preco_unitario = $price;
            $item->total = $item->quantidade * $price;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'product_size_id' => $sizeId,
                'quantidade' => $qty,
                'preco_unitario' => $price,
                'total' => $qty * $price,
            ]);
        }

        return $this->recalculate($cart);
    }

    public function updateItem(Cart $cart, CartItem $item, int $qty): Cart
    {
        $this->ensureCartItem($cart, $item);
        $item->quantidade = $qty;
        $item->total = $item->quantidade * $item->preco_unitario;
        $item->save();

        return $this->recalculate($cart);
    }

    public function removeItem(Cart $cart, CartItem $item): Cart
    {
        $this->ensureCartItem($cart, $item);
        $item->delete();

        return $this->recalculate($cart);
    }

    public function applyCoupon(Cart $cart, string $codigo): Cart
    {
        $coupon = Coupon::where('codigo', $codigo)->first();

        if (!$coupon || !$coupon->isValidForTotal($cart->subtotal)) {
            throw ValidationException::withMessages([
                'cupom' => 'Cupom inválido ou expirado.',
            ]);
        }

        $cart->coupon()->associate($coupon);
        return $this->recalculate($cart);
    }

    public function recalculate(Cart $cart): Cart
    {
        $cart->load('items');
        $subtotal = $cart->items->sum('total');
        $desconto = 0;

        if ($cart->coupon) {
            $desconto = $this->calculateDiscount($cart->coupon, $subtotal);
        }

        $cart->update([
            'subtotal' => $subtotal,
            'desconto' => $desconto,
            'total' => max(0, $subtotal - $desconto),
        ]);

        return $cart->fresh('items.product', 'items.size', 'coupon');
    }

    protected function calculateDiscount(Coupon $coupon, float $subtotal): float
    {
        if (!$coupon->isValidForTotal($subtotal)) {
            return 0;
        }

        return $coupon->tipo === 'percentual'
            ? round($subtotal * ($coupon->valor / 100), 2)
            : min($coupon->valor, $subtotal);
    }

    protected function ensureCartItem(Cart $cart, CartItem $item): void
    {
        if ($item->cart_id !== $cart->id) {
            throw ValidationException::withMessages([
                'item' => 'Item não pertence ao carrinho informado.',
            ]);
        }
    }
}
