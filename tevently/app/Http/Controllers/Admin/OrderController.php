<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
	// show paginated list of orders if model exists, otherwise empty collection
	public function index(Request $request)
	{
		$orders = collect();

		if (class_exists(\App\Models\Order::class)) {
			$orders = \App\Models\Order::latest()->paginate(15);
		}

		return view('admin.orders.index', compact('orders'));
	}

	// show single order (if model exists)
	public function show($id)
	{
		if (class_exists(\App\Models\Order::class)) {
			$order = \App\Models\Order::findOrFail($id);
			return view('admin.orders.show', compact('order'));
		}

		abort(404);
	}
}
