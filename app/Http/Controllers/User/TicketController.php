<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function show(OrderItem $orderItem)
    {
        if ($orderItem->order->user_id !== Auth::id()) {
            abort(403, 'Akses tidak sah.');
        }

        if ($orderItem->order->status !== 'confirmed') {
            return redirect()->route('user.orders.show', $orderItem->order)
                             ->with('error', 'Tiket hanya tersedia untuk pesanan yang sudah dikonfirmasi.');
        }

        $orderItem->load(['ticket', 'order.event', 'order.user']);

        return view('user.tickets', ['item' => $orderItem, 'ticket' => $orderItem->ticket]);
    }
}