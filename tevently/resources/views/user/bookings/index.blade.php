@extends('user.partials.navbar')

@section('title', 'Pemesanan Saya')
@section('heading', 'Pemesanan Saya')
@section('subheading', 'Daftar tiket event yang telah Anda pesan')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="max-w-4xl mx-auto px-4 py-8">
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6 font-medium shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-xl mb-6 font-medium shadow-sm">{{ session('error') }}</div>
    @endif

    @if($bookings instanceof \Illuminate\Pagination\AbstractPaginator && $bookings->count())
        <div class="bg-white rounded-2xl shadow-xl border p-6 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-soft-pink-light">
                        <tr>
                            <th class="p-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">ID</th>
                            <th class="p-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Event</th>
                            <th class="p-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Tiket</th>
                            <th class="p-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Qty</th>
                            <th class="p-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Total</th>
                            <th class="p-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Status</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($bookings as $b)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-semibold text-gray-700">{{ $b->id }}</td>
                                
                                <td class="p-4">
                                    <div class="font-medium text-custom-dark">{{ $b->event->title ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $b->event->location ?? '-' }}</div>
                                </td>
                                
                                <td class="p-4 text-sm text-gray-700">{{ $b->ticket->name ?? '-' }}</td>
                                
                                <td class="p-4 font-semibold text-gray-700">{{ $b->total_tickets ?? $b->quantity }}</td>
                                
                                <td class="p-4 font-bold text-main-purple">Rp {{ number_format($b->total_amount ?? 0, 0, ',', '.') }}</td>
                                
                                <td class="p-4">
                                    @php
                                        $statusClass = [
                                            'approved' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ][$b->status ?? 'pending'] ?? 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($b->status ?? '-') }}
                                    </span>
                                </td>
                                
                                <td class="p-4 text-right">
                                    <a href="{{ route('bookings.show', $b->id) }}" class="text-main-purple hover:text-custom-dark font-semibold text-sm transition">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-xl p-10 text-center border border-gray-100">
            <svg class="mx-auto h-12 w-12 text-[#cc8db3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
            <p class="text-gray-600 text-lg mt-4 mb-6">Belum ada pemesanan tiket. Jelajahi acara dan pesan tiket sekarang.</p>
            <a href="{{ route('guest.events.index') }}" class="mt-4 inline-block bg-main-purple text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#9d85b6] shadow-md transition transform hover:-translate-y-0.5">
                Jelajahi Events
            </a>
        </div>
    @endif
</div>
@endsection