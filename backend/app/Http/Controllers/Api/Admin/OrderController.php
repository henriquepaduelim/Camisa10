<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items', 'user');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($request->filled('de')) {
            $query->whereDate('created_at', '>=', $request->get('de'));
        }

        if ($request->filled('ate')) {
            $query->whereDate('created_at', '<=', $request->get('ate'));
        }

        return response()->json(['data' => $query->latest()->paginate(20)]);
    }

    public function show(Order $pedido)
    {
        return response()->json(['data' => $pedido->load('items', 'user', 'address', 'coupon')]);
    }

    public function atualizarStatus(Request $request, Order $pedido)
    {
        $request->validate([
            'status' => 'required|in:pendente,pago,enviado,entregue,cancelado',
            'comentario' => 'nullable|string|max:500',
        ]);

        $pedido->update(['status' => $request->status]);

        OrderStatusHistory::create([
            'order_id' => $pedido->id,
            'status' => $request->status,
            'comentario' => $request->comentario,
        ]);

        return response()->json(['data' => $pedido->fresh()]);
    }
}
