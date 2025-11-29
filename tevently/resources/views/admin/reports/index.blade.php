@extends('layouts.admin')

@section('title', 'Reports Dashboard')
@section('heading', 'Reports Dashboard')
@section('subheading', 'Ringkasan laporan dan statistik')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Revenue -->
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Total Revenue</p>
                <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Orders</p>
                <p class="text-2xl font-bold mt-1">{{ number_format($totalOrders) }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Events -->
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Total Events</p>
                <p class="text-2xl font-bold mt-1">{{ number_format($totalEvents) }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Total Users</p>
                <p class="text-2xl font-bold mt-1">{{ number_format($totalUsers) }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <a href="{{ route('admin.reports.sales') }}" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-indigo-500 hover:shadow-md transition">
        <div class="flex items-center gap-3">
            <div class="bg-indigo-100 text-indigo-600 rounded-lg p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Sales Report</h3>
                <p class="text-sm text-gray-500">Detail transaksi penjualan</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.reports.events') }}" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:shadow-md transition">
        <div class="flex items-center gap-3">
            <div class="bg-purple-100 text-purple-600 rounded-lg p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Events Report</h3>
                <p class="text-sm text-gray-500">Performa setiap event</p>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.reports.users') }}" class="block p-4 border-2 border-gray-200 rounded-lg hover:border-green-500 hover:shadow-md transition">
        <div class="flex items-center gap-3">
            <div class="bg-green-100 text-green-600 rounded-lg p-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">Users Report</h3>
                <p class="text-sm text-gray-500">Aktivitas pengguna</p>
            </div>
        </div>
    </a>
</div>

<!-- Top Events by Revenue -->
<div class="mb-6">
    <h2 class="text-lg font-semibold mb-4">Top 5 Events by Revenue</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($topEvents as $event)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $event->name }}</div>
                        <div class="text-sm text-gray-500">{{ $event->location }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ number_format($event->total_orders) }}
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-green-600">
                        Rp {{ number_format($event->total_revenue ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data event dengan revenue
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Orders -->
<div>
    <h2 class="text-lg font-semibold mb-4">Recent Approved Orders</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        #{{ $order->id }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $order->user->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        {{ $order->event->name ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 text-sm font-semibold text-green-600">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        Belum ada order yang disetujui
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection