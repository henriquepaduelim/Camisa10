<?php

use App\Models\Category;
use App\Models\Club;
use App\Models\League;
use App\Models\Product;
use App\Services\CartService;
use App\Services\ProductService;
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
Route::post('/login', [AuthController::class, 'login']);
Route::get('/registrar', [AuthController::class, 'showRegister']);
Route::post('/registrar', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/conta', function () {
        $user = auth()->user()->load('orders.items');
        return view('conta', compact('user'));
    });
});
