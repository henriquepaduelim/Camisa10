<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        // Em produção, força https para evitar mixed content atrás de proxy.
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

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
