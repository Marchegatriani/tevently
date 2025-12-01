@extends('organizer.partials.navbar')

@section('title', 'Detail Pesanan')
@section('heading', 'Detail Pesanan')
@section('subheading', 'Informasi lengkap dan aksi terkait pesanan #{{ $order->id }}')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
</style>

<div class="space-y-6">
    
    <div class="flex justify-start">
        <a href="{{ route('organizer.orders.index') }}" class="bg-gray-300 text-custom-dark px-5 py-2 rounded-xl font-semibold hover:bg-gray-400 transition shadow-md">
            ← Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
        
        <div class="flex flex-wrap items-start justify-between border-b border-gray-100 pb-4 mb-6">
            <div class="mb-4 md:mb-0">
                <h3 class="text-2xl font-extrabold text-custom-dark mb-1">Pesanan #{{ $order->id }}</h3>
                <p class="text-gray-600 text-sm">Pelanggan: <span class="font-medium text-custom-dark">{{ $order->user->name ?? '-' }} ({{ $order->user->email ?? '-' }})</span></p>
                <p class="text-gray-600 text-sm">Event: <span class="font-medium text-custom-dark">{{ $order->event->title ?? '-' }}</span></p>
            </div>
            
            <div class="text-right">
                @php
                    $statusClass = [
                        'approved' => 'bg-green-600',
                        'pending' => 'bg-yellow-500',
                        'cancelled' => 'bg-red-600',
                        'completed' => 'bg-blue-600',
                    ][$order->status ?? 'pending'] ?? 'bg-gray-500';
                @endphp
                <p class="text-sm text-gray-500 mb-1">Status:</p>
                <span class="px-4 py-2 rounded-full text-sm font-bold text-white {{ $statusClass }} shadow-md">
                    {{ ucfirst($order->status ?? '-') }}
                </span>
                <p class="text-lg font-extrabold text-main-purple mt-2">Rp {{ number_format($order->total_amount ?? 0,0,',','.') }}</p>
            </div>
        </div>

        <div class="mb-8">
            <h4 class="text-xl font-bold text-custom-dark mb-4 border-b pb-2">Detail Pembelian</h4>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">
                
                <div class="border-b border-gray-100 pb-2">
                    <dt class="text-gray-500 font-medium">Jenis Tiket</dt>
                    <dd class="font-bold text-custom-dark text-lg">{{ $order->ticket->name ?? '-' }}</dd>
                    <dd class="text-gray-500">Harga Satuan: Rp {{ number_format($order->ticket->price ?? 0, 0, ',', '.') }}</dd>
                </div>
                
                <div class="border-b border-gray-100 pb-2">
                    <dt class="text-gray-500 font-medium">Kuantitas</dt>
                    <dd class="font-bold text-custom-dark text-lg">{{ $order->total_tickets ?? $order->quantity }}</dd>
                </div>

                <div class="border-b border-gray-100 pb-2">
                    <dt class="text-gray-500 font-medium">Tanggal Pesanan</dt>
                    <dd class="font-medium text-custom-dark">{{ $order->created_at->format('d F Y H:i') }}</dd>
                </div>
                
                <div class="border-b border-gray-100 pb-2">
                    <dt class="text-gray-500 font-medium">Total Harga</dt>
                    <dd class="font-extrabold text-main-purple text-xl">Rp {{ number_format($order->total_amount ?? 0, 0, ',', '.') }}</dd>
                </div>

            </dl>
        </div>

        <div class="mt-6 pt-4 border-t border-gray-100">
            <h4 class="text-xl font-bold text-custom-dark mb-4">Aksi Cepat</h4>
            
            <div class="flex gap-4">
                @if($order->status === 'pending')
                    
                    <form method="POST" action="{{ route('organizer.orders.approve', $order->id) }}">
                        @csrf
                        <button class="px-5 py-3 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition shadow-md">
                            Setujui Pesanan
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('organizer.orders.cancel', $order->id) }}">
                        @csrf
                        <button class="px-5 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition shadow-md"
                                onclick="return confirm('Apakah Anda yakin ingin menolak atau membatalkan pesanan ini?')">
                            Batalkan Pesanan
                        </button>
                    </form>
                    
                @elseif($order->status === 'approved' || $order->status === 'confirmed')
                    
                    <form method="POST" action="{{ route('organizer.orders.cancel', $order->id) }}">
                        @csrf
                        <button class="px-5 py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition shadow-md"
                                onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan yang sudah disetujui? Stok akan dikembalikan.')">
                            Batalkan Pesanan
                        </button>
                    </form>

                    <p class="text-sm text-gray-500 self-center">Pesanan telah disetujui.</p>

                @else
                    <p class="text-gray-600 text-sm">Tidak ada aksi lebih lanjut yang tersedia untuk status **{{ ucfirst($order->status) }}**.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection