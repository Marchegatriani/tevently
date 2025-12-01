@extends('admin.partials.navbar')

@section('title', 'Buat Event')
@section('heading', 'Buat Event Baru')
@section('subheading', 'Formulir detail acara')

@section('header-actions')
    <a href="{{ route('admin.events.index') }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-xl text-sm font-semibold hover:bg-gray-600 transition shadow-md">
        ← Kembali ke Daftar Event
    </a>
@endsection

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
</style>

<div class="max-w-7xl mx-auto p-0 px-2">
    <div class="bg-white shadow-2xl rounded-2xl p-8 border border-gray-100">
        
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            @csrf
            <div class="flex flex-col items-center p-4 bg-gray-50 rounded-xl border border-gray-100 h-fit lg:sticky lg:top-4 lg:self-start">
                <label for="image" class="block text-custom-dark font-bold mb-4 text-center">Gambar Event <span class="text-red-500">*</span></label>
                
                <div class="relative w-full max-w-xs">
                    <img id="image-preview" 
                        src="https://placehold.co/400x300/837ab6/f7c2ca?text=Upload+Gambar+(Min+3:2)" 
                        alt="Event Image" 
                        class="w-full h-48 rounded-2xl border-4 border-gray-200 object-cover cursor-pointer shadow-lg transition hover:border-[#cc8db3]" 
                        onclick="document.getElementById('image').click();">
                    
                    <input type="file" id="image" name="image" class="hidden" onchange="previewEventImage(event);">
                </div>
                
                <p class="text-gray-500 text-xs mt-3 text-center">Klik gambar untuk mengunggah (Maks 2MB)</p>
                @error('image')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="lg:col-span-2 space-y-6">
                
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded-xl">
                        <strong class="font-bold">Terjadi beberapa kesalahan:</strong>
                        <ul class="mt-2 text-sm list-disc ml-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div>
                    <label for="title" class="block text-custom-dark font-semibold mb-2">Judul Event <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition"
                        placeholder="Masukkan judul event" required>
                    @error('title')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Description Input -->
                <div>
                    <label for="description" class="block text-custom-dark font-semibold mb-2">Deskripsi <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" 
                        class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition"
                        rows="4" placeholder="Jelaskan event Anda secara rinci" required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category Selection -->
                <div>
                    <label for="category_id" class="block text-custom-dark font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select id="category_id" name="category_id" 
                        class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition"
                        required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Date -->
                    <div>
                        <label for="event_date" class="block text-custom-dark font-semibold mb-2">Tanggal Event <span class="text-red-500">*</span></label>
                        <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
                          min="{{ date('Y-m-d') }}"
                          class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition"
                          required>
                        @error('event_date')
                          <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Time -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                          <label for="start_time" class="block text-custom-dark font-semibold mb-2">Waktu Mulai <span class="text-red-500">*</span></label>
                          <input type="time" id="start_time" name="start_time" value="{{ old('start_time', '19:00') }}"
                            class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition"
                            required>
                        </div>
                        <div>
                          <label for="end_time" class="block text-custom-dark font-semibold mb-2">Waktu Selesai <span class="text-red-500">*</span></label>
                          <input type="time" id="end_time" name="end_time" value="{{ old('end_time', '22:00') }}"
                            class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition"
                            required>
                        </div>
                        @error('start_time')
                          <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                        @error('end_time')
                          <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Location Input -->
                <div>
                    <label for="location" class="block text-custom-dark font-semibold mb-2">Lokasi <span class="text-red-500">*</span></label>
                    <input type="text" id="location" name="location" value="{{ old('location') }}"
                        placeholder="Contoh: Grand Ballroom, Hotel XYZ, Jakarta"
                        class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition"
                        required>
                    @error('location')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Max Attendees Input -->
                <div>
                    <label for="max_attendees" class="block text-custom-dark font-semibold mb-2">Kapasitas Maksimum <span class="text-red-500">*</span></label>
                    <input type="number" id="max_attendees" name="max_attendees" value="{{ old('max_attendees', 50) }}"
                        min="1"
                        class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition"
                        required>
                    @error('max_attendees')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status Selection -->
                <div>
                    <label for="status" class="block text-custom-dark font-semibold mb-2">Status</label>
                    <select id="status" name="status" 
                        class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-gray-300 shadow-sm focus:ring-main-purple focus:border-main-purple transition">
                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Sekarang</option>
                    </select>
                    <p class="text-gray-500 text-sm mt-1">
                        <strong>Catatan:</strong> Setelah membuat event, Anda akan diarahkan untuk menambahkan tiket.
                    </p>
                </div>
                
                <!-- Submit Buttons -->
                <div class="flex justify-start space-x-4 pt-4">
                    <button type="submit" 
                        class="bg-main-purple text-white px-6 py-3 rounded-xl font-bold hover:bg-[#9d85b6] transition duration-300 shadow-lg shadow-[#837ab6]/40 transform hover:-translate-y-0.5">
                        Buat Event & Tambah Tiket
                    </button>
                    <a href="{{ route('admin.events.index') }}" 
                        class="text-center bg-gray-300 text-gray-700 px-6 py-3 rounded-xl font-bold hover:bg-gray-400 transition duration-300 transform hover:-translate-y-0.5">
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
</main>

<script>
    function previewEventImage(event) {
        const preview = document.getElementById('image-preview');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
        }
    }
    document.addEventListener('DOMContentLoaded', () => {
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');

        if (startTimeInput && endTimeInput) {
            startTimeInput.addEventListener('change', function() {
                endTimeInput.min = this.value;
                
                if (endTimeInput.value && endTimeInput.value < this.value) {
                    endTimeInput.value = '';
                }
            });
            endTimeInput.min = startTimeInput.value;
        }
    });
</script>
@endsection