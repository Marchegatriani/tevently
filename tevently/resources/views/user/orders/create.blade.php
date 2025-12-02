@extends('layouts.user')

@section('title', 'Checkout Tiket')
@section('heading', 'Checkout Tiket')
@section('subheading', 'Selesaikan pemesanan tiket Anda')

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
</style>

<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="bg-white rounded-3xl shadow-2xl p-8 border border-gray-100">
        
        <h2 class="text-3xl font-bold text-custom-dark mb-2">Checkout Pemesanan</h2>
        <p class="text-gray-600 mb-6">Acara: <strong class="text-main-purple">{{ $event->title }}</strong></p>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800 p-4 rounded-xl mb-6 font-medium shadow-sm">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('user.orders.store', [$event, $ticket]) }}">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-custom-dark border-b pb-2">Detail Pembelian</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Harga Satuan</label>
                        <div class="text-2xl font-extrabold text-pink-accent">Rp {{ number_format($ticket->price, 0, ',', '.') }}</div>
                        <p class="text-xs text-gray-500 mt-1">Jenis Tiket: {{ $ticket->name }}</p>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-semibold text-custom-dark mb-2">
                            Kuantitas
                        </label>
                        <p class="text-xs text-gray-500 mb-1">Tersedia: {{ $remaining }}, Maks per pesanan: {{ $max_per_order }}</p>
                        
                        <input type="number" 
                               name="quantity" 
                               id="quantity"
                               value="{{ old('quantity', 1) }}" 
                               min="1" 
                               max="{{ min($remaining, $max_per_order) }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-main-purple focus:border-main-purple transition @error('quantity') border-red-500 @enderror">
                        
                        @error('quantity') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 h-fit sticky top-4">
                    <h3 class="text-xl font-bold text-custom-dark mb-4 border-b pb-3">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga Tiket (per unit):</span>
                            <span class="font-semibold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Layanan:</span>
                            <span class="font-semibold">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-lg pt-3 border-t border-gray-200">
                            <span class="font-bold text-custom-dark">Total Perkiraan:</span>
                            <span id="total-display" class="font-extrabold text-main-purple">Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 mt-4">Total akan diperbarui setelah Anda memasukkan kuantitas di sebelah kiri.</p>
                </div>
            </div>

            <div class="flex gap-4 items-center pt-8 border-t border-gray-100 mt-8">
                <button type="submit" 
                        class="bg-main-purple text-white px-6 py-3 rounded-xl font-bold hover:bg-[#9d85b6] transition shadow-lg transform hover:-translate-y-0.5">
                    Bayar / Pesan Sekarang
                </button>
                <a href="{{ route('user.events.show', $event) }}" class="text-sm text-gray-600 hover:text-custom-dark font-medium">
                    ← Kembali ke Event
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const totalDisplay = document.getElementById('total-display');
    const ticketPrice = {{ $ticket->price }};

    function updateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const totalAmount = quantity * ticketPrice;
        
        totalDisplay.textContent = 'Rp ' + totalAmount.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }
    quantityInput.addEventListener('input', updateTotal);
    updateTotal(); 
});
</script>
@endsection