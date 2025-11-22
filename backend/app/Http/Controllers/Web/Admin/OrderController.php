<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $pedidos = Order::with('user')->latest()->paginate(15);
        return view('admin.orders', compact('pedidos'));
    }

    public function updateStatus(Request $request, Order $pedido)
    {
        $data = $request->validate([
            'status' => 'required|in:pendente,pago,enviado,entregue,cancelado',
            'comentario' => 'nullable|string|max:255',
        ]);

        $pedido->update(['status' => $data['status']]);
        OrderStatusHistory::create([
            'order_id' => $pedido->id,
            'status' => $data['status'],
            'comentario' => $data['comentario'] ?? null,
        ]);

        return back()->with('success', 'Status atualizado.');
    }
}
