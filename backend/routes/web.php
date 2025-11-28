<?php

use App\Models\Category;
use App\Models\Club;
use App\Models\League;
use App\Models\Product;
use App\Services\CartService;
use App\Services\ProductService;
use App\Http\Controllers\Web\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Web\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Web\Admin\TaxonomyController as AdminTaxonomyController;
use App\Http\Controllers\Web\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Web\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Web\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Web\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $destaques = Product::with('images')->where('destaque', true)->take(8)->get();
    $maisVendidos = Product::with('images')->where('mais_vendido', true)->take(8)->get();

    return view('home', compact('destaques', 'maisVendidos'));
});

Route::get('/produtos', function (\Illuminate\Http\Request $request, ProductService $service) {
    $produtos = $service->list($request->all(), 12);
    $clubes = Club::all();
    $ligas = League::all();
    $categorias = Category::all();

    return view('produtos.index', compact('produtos', 'clubes', 'ligas', 'categorias'));
});

Route::get('/produtos/{slug}', function (string $slug) {
    $produto = Product::with('images', 'sizes', 'club', 'league', 'category')->where('slug', $slug)->firstOrFail();
    $relacionados = Product::with('images')->where('id', '!=', $produto->id)->take(4)->get();

    return view('produtos.show', compact('produto', 'relacionados'));
});

Route::get('/carrinho', function (CartService $cartService) {
    $cart = $cartService->getCart(auth()->user());
    return view('carrinho', compact('cart'));
});

Route::view('/faq', 'static.faq');
Route::view('/contato', 'static.contato');
Route::view('/termos', 'static.termos');
Route::view('/privacidade', 'static.privacidade');

Route::post('/carrinho/cupom', function (Request $request, CartService $cartService) {
    $data = $request->validate([
        'cupom' => 'required|string',
    ], [
        'required' => 'Informe o cupom.',
    ]);

    $cart = $cartService->getCart(auth()->user());
    try {
        $cartService->applyCoupon($cart, $data['cupom']);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    }

    return back()->with('success', 'Cupom aplicado com sucesso.');
});

Route::post('/carrinho', function (Request $request, CartService $cartService) {
    $data = $request->validate([
        'product_id' => 'required|exists:products,id',
        'product_size_id' => 'nullable|exists:product_sizes,id',
        'quantidade' => 'required|integer|min:1',
    ], [
        'required' => 'Campo obrigatório.',
        'integer' => 'Informe um número válido.',
        'min' => 'Quantidade mínima é 1.',
    ]);

    $cart = $cartService->getCart(auth()->user());
    try {
        $cartService->addItem($cart, (int) $data['product_id'], $data['product_size_id'] ?? null, (int) $data['quantidade']);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    }

    return back()->with('success', 'Produto adicionado ao carrinho.');
});

Route::get('/checkout', function (CartService $cartService) {
    $cart = $cartService->getCart(auth()->user());
    return view('checkout', compact('cart'));
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/registrar', [AuthController::class, 'showRegister']);
Route::post('/registrar', [AuthController::class, 'register'])->middleware('throttle:8,1');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/conta', function () {
        $user = auth()->user()->load('orders.items');
        return view('conta', compact('user'));
    });
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/produtos', [AdminProductController::class, 'index'])->name('admin.produtos');
        Route::post('/produtos', [AdminProductController::class, 'store'])->name('admin.produtos.store');
        Route::get('/produtos/{produto}/editar', [AdminProductController::class, 'edit'])->name('admin.produtos.edit');
        Route::patch('/produtos/{produto}', [AdminProductController::class, 'update'])->name('admin.produtos.update');
        Route::patch('/produtos/{produto}/status', [AdminProductController::class, 'toggleStatus'])->name('admin.produtos.status');
        Route::delete('/produtos/{produto}', [AdminProductController::class, 'destroy'])->name('admin.produtos.destroy');

        Route::get('/taxonomias', [AdminTaxonomyController::class, 'index'])->name('admin.taxonomias');
        Route::post('/categorias', [AdminTaxonomyController::class, 'storeCategory'])->name('admin.categorias.store');
        Route::delete('/categorias/{categoria}', [AdminTaxonomyController::class, 'destroyCategory'])->name('admin.categorias.destroy');
        Route::post('/clubes', [AdminTaxonomyController::class, 'storeClub'])->name('admin.clubes.store');
        Route::delete('/clubes/{clube}', [AdminTaxonomyController::class, 'destroyClub'])->name('admin.clubes.destroy');
        Route::post('/ligas', [AdminTaxonomyController::class, 'storeLeague'])->name('admin.ligas.store');
        Route::delete('/ligas/{liga}', [AdminTaxonomyController::class, 'destroyLeague'])->name('admin.ligas.destroy');

        Route::get('/cupons', [AdminCouponController::class, 'index'])->name('admin.cupons');
        Route::post('/cupons', [AdminCouponController::class, 'store'])->name('admin.cupons.store');
        Route::patch('/cupons/{cupom}', [AdminCouponController::class, 'update'])->name('admin.cupons.update');
        Route::patch('/cupons/{cupom}/ativo', [AdminCouponController::class, 'toggleAtivo'])->name('admin.cupons.ativo');
        Route::delete('/cupons/{cupom}', [AdminCouponController::class, 'destroy'])->name('admin.cupons.destroy');

        Route::get('/pedidos', [AdminOrderController::class, 'index'])->name('admin.pedidos');
        Route::patch('/pedidos/{pedido}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.pedidos.status');

        Route::get('/configuracoes', [AdminSettingController::class, 'index'])->name('admin.settings');
        Route::post('/configuracoes', [AdminSettingController::class, 'update'])->name('admin.settings.update');
    });
});
