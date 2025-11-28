<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items', 'address')->latest();

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('id', $search)
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($date = $request->input('data')) {
            $query->whereDate('created_at', $date);
        }

        $pedidos = $query->paginate(15)->withQueryString();

        return view('admin.orders', [
            'pedidos' => $pedidos,
            'filtros' => $request->only(['q', 'status', 'data']),
        ]);
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
