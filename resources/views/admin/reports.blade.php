@extends('layouts.admin')

@section('title', 'Dashboard Laporan')
@section('heading', 'Dashboard Laporan')
@section('subheading', 'Ringkasan laporan dan statistik sistem')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 px-2">
    <div class="bg-gradient-to-br from-[#837ab6] to-[#9d85b6] rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#f7c2ca] text-sm font-medium uppercase">Total Pendapatan</p>
                <p class="text-3xl font-bold mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-[#cc8db3] to-[#f6a5c0] rounded-2xl p-6 text-custom-dark shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-custom-dark text-opacity-80 text-sm font-medium uppercase">Total Pesanan</p>
                <p class="text-3xl font-bold mt-1">{{ number_format($totalOrders) }}</p>
            </div>
            <div class="bg-custom-dark bg-opacity-20 rounded-full p-3 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-[#837ab6] to-[#9d85b6] rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-[#f7c2ca] text-sm font-medium uppercase">Total Event</p>
                <p class="text-3xl font-bold mt-1">{{ number_format($totalEvents) }}</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-[#cc8db3] to-[#f6a5c0] rounded-2xl p-6 text-custom-dark shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-custom-dark text-opacity-80 text-sm font-medium uppercase">Total Pengguna</p>
                <p class="text-3xl font-bold mt-1">{{ number_format($totalUsers) }}</p>
            </div>
            <div class="bg-custom-dark bg-opacity-20 rounded-full p-3 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </div>
    </div>
</div>

    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 mb-8">
        <h2 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Top 5 Event Berdasarkan Pendapatan</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-soft-pink-light">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Nama Event</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Total Pesanan</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($topEvents as $event)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-custom-dark">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-custom-dark">{{ $event->name }}</div>
                            <div class="text-xs text-gray-500">{{ $event->location }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-custom-dark font-medium">
                            {{ number_format($event->total_orders) }}
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-[#837ab6]">
                            Rp {{ number_format($event->total_revenue ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data event dengan pendapatan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        <h2 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">5 Pesanan Terbaru yang Disetujui</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-soft-pink-light">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-semibold text-custom-dark">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-custom-dark">{{ $order->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-custom-dark">{{ $order->event->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-main-purple">
                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada pesanan yang disetujui baru-baru ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection