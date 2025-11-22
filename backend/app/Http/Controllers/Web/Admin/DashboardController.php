<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'produtos' => Product::count(),
            'pedidos' => Order::count(),
            'clientes' => User::where('role', 'cliente')->count(),
            'cupons' => Coupon::count(),
            'carrinhos' => Cart::count(),
        ];

        $pedidosRecentes = Order::with('user')->latest()->take(5)->get();
        $produtosTop = Product::orderByDesc('mais_vendido')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pedidosRecentes', 'produtosTop'));
    }
}
