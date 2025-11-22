<?php

use App\Http\Controllers\Api\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Api\Admin\TaxonomyController as AdminTaxonomyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Models\Category;
use App\Models\Club;
use App\Models\League;
use Illuminate\Support\Facades\Route;

Route::post('registrar', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('produtos', [ProductController::class, 'index']);
Route::get('produtos/{slug}', [ProductController::class, 'show']);

Route::get('categorias', fn () => response()->json(['data' => Category::all()]));
Route::get('clubes', fn () => response()->json(['data' => Club::all()]));
Route::get('ligas', fn () => response()->json(['data' => League::all()]));

Route::get('carrinho', [CartController::class, 'show']);
Route::post('carrinho', [CartController::class, 'store']);
Route::patch('carrinho/{item}', [CartController::class, 'update']);
Route::delete('carrinho/{item}', [CartController::class, 'destroy']);
Route::post('carrinho/cupom', [CartController::class, 'aplicarCupom']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::put('me', [AuthController::class, 'updateProfile']);

    Route::post('checkout', CheckoutController::class);
    Route::get('pedidos', [OrderController::class, 'index']);
    Route::get('pedidos/{pedido}', [OrderController::class, 'show']);

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::apiResource('produtos', AdminProductController::class);
        Route::apiResource('categorias', AdminTaxonomyController::class);
        Route::apiResource('clubes', AdminTaxonomyController::class);
        Route::apiResource('ligas', AdminTaxonomyController::class);
        Route::apiResource('cupons', AdminCouponController::class);
        Route::get('pedidos', [AdminOrderController::class, 'index']);
        Route::get('pedidos/{pedido}', [AdminOrderController::class, 'show']);
        Route::patch('pedidos/{pedido}/status', [AdminOrderController::class, 'atualizarStatus']);
        Route::get('settings', [AdminSettingController::class, 'index']);
        Route::put('settings', [AdminSettingController::class, 'update']);
    });
});
