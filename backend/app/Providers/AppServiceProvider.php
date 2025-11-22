<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Services\CartService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (!Schema::hasTable('carts')) {
                $view->with('cartCount', 0);
                return;
            }

            $cartService = app(CartService::class);
            $cart = $cartService->getCart(auth()->user());
            $view->with('cartCount', $cart->items->sum('quantidade'));
        });
    }
}
