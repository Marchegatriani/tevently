<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
	// show paginated list of orders if model exists, otherwise empty collection
	public function index(Request $request)
	{
		$query = Order::with(['event','ticket','user'])->latest();

		if ($request->filled('status')) {
			$query->where('status', $request->input('status'));
		}

		$orders = $query->paginate(20);

		return view('admin.orders.index', compact('orders'));
	}

	// show single order (if model exists)
	public function show($id)
	{
		$order = Order::with(['event','ticket','user'])->findOrFail($id);
		return view('admin.orders.show', compact('order'));
	}

	public function approve($id)
	{
		$order = Order::findOrFail($id);
		if ($order->status !== 'pending') {
			return back()->with('info', 'Order tidak dalam status pending.');
		}
		$order->status = 'confirmed';
		$order->save();

		return back()->with('success', 'Order berhasil dikonfirmasi oleh admin.');
	}

	public function cancel($id)
	{
		$order = Order::with('ticket')->findOrFail($id);
		if ($order->status === 'cancelled') {
			return back()->with('info', 'Order sudah dibatalkan.');
		}

		DB::transaction(function () use ($order) {
			if ($order->ticket) {
				$decrement = (int) ($order->total_tickets ?? $order->quantity ?? 0);
				$order->ticket->quantity_sold = max(0, $order->ticket->quantity_sold - $decrement);
				$order->ticket->save();
			}
			$order->status = 'cancelled';
			$order->save();
		});

		return back()->with('success', 'Order berhasil dibatalkan oleh admin.');
	}
}
