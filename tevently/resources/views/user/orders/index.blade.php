@extends('layouts.user')

@section('title', 'Kelola Pemesanan')
@section('heading', 'Kelola Pemesanan')
@section('subheading', 'Daftar dan status pesanan tiket acara Anda')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .text-main-purple { color: #837ab6; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="space-y-6 px-8">
    @if(session('success')) 
        <div class="bg-green-100 p-4 rounded-xl border border-green-400 text-green-800 font-medium shadow-sm">{{ session('success') }}</div> 
    @endif
    @if(session('error')) 
        <div class="bg-red-100 p-4 rounded-xl border border-red-400 text-red-800 font-medium shadow-sm">{{ session('error') }}</div> 
    @endif

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-soft-pink-light">
                    <tr>
                        <th class="py-2 px-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider w-10">No</th>
                        <th class="py-2 px-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Event & Detail</th>
                        <th class="py-2 px-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Total</th>
                        <th class="py-2 px-4 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Status</th>
                        <th class="py-2 px-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $i => $o)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-4 font-semibold text-gray-700">{{ $orders->firstItem() + $i }}</td>
                            <td class="p-4 text-sm text-gray-700 whitespace-nowrap">
                                <div class="font-medium text-custom-dark">{{ $o->event->title ?? '-' }}</div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ $o->ticket->name ?? 'Tiket' }} &bull; {{ $o->total_tickets ?? $o->quantity }} pcs
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ $o->user->name ?? '-' }} ({{ $o->user->email ?? $o->user_email ?? '-' }})
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    Tanggal: {{ optional($o->event->event_date)->format('d M Y') ?? '-' }}
                                </div>
                            </td>
                            
                            <td class="p-2 font-bold text-main-purple whitespace-nowrap">
                                Rp {{ number_format($o->total_amount ?? 0,0,',','.') }}
                            </td>
                            
                            <td class="p-4 whitespace-nowrap">
                                @php
                                    $statusClass = [
                                        'completed' => 'bg-green-100 text-green-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $currentStatusClass = $statusClass[$o->status ?? 'pending'] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="px-4 py-1 text-xs font-semibold rounded-full {{ $currentStatusClass }}">
                                    {{ ucfirst($o->status ?? '-') }}
                                </span>
                            </td>
                            
                            <td class="p-4 text-right">
                                <a href="{{ route('user.orders.show', $o->id) }}" class="text-main-purple hover:text-custom-dark font-semibold text-sm transition whitespace-nowrap">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-8 text-center text-gray-500 text-lg">Belum ada pesanan tiket untuk acara Anda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-4 border-t border-gray-200 flex justify-end">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection