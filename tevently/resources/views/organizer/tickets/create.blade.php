@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="text-sm text-gray-600">
            <a href="{{ route('organizer.events.index') }}" class="hover:text-blue-600">My Events</a>
            <span class="mx-2">/</span>
            <a href="{{ route('organizer.events.tickets.index', $event) }}" class="hover:text-blue-600">
                {{ $event->name }}
            </a>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800">Create Ticket</span>
        </nav>
    </div>

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Create New Ticket</h1>
        <p class="text-gray-600 mt-1">Buat tiket baru untuk event: <strong>{{ $event->name }}</strong></p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.events.tickets.store', $event) }}" method="POST">
            @csrf

            <!-- Ticket Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Ticket Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       placeholder="e.g. VIP, Regular, Early Bird"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          placeholder="Describe this ticket type..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Quota Row -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Price (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           value="{{ old('price') }}"
                           min="0"
                           step="0.01"
                           placeholder="50000"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-500 @enderror" 
                           required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quota -->
                <div>
                    <label for="quota" class="block text-sm font-medium text-gray-700 mb-2">
                        Total Quota <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="quota" 
                           name="quota" 
                           value="{{ old('quota') }}"
                           min="1"
                           placeholder="100"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('quota') border-red-500 @enderror" 
                           required>
                    @error('quota')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Max Per Order -->
            <div class="mb-6">
                <label for="max_per_order" class="block text-sm font-medium text-gray-700 mb-2">
                    Max Per Order <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       id="max_per_order" 
                       name="max_per_order" 
                       value="{{ old('max_per_order', 5) }}"
                       min="1"
                       placeholder="5"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_per_order') border-red-500 @enderror" 
                       required>
                <p class="text-sm text-gray-500 mt-1">Maximum tickets a customer can buy in one order</p>
                @error('max_per_order')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sales Period -->
            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Sales Start -->
                <div>
                    <label for="sales_start" class="block text-sm font-medium text-gray-700 mb-2">
                        Sales Start
                    </label>
                    <input type="datetime-local" 
                           id="sales_start" 
                           name="sales_start" 
                           value="{{ old('sales_start') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sales_start') border-red-500 @enderror">
                    @error('sales_start')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sales End -->
                <div>
                    <label for="sales_end" class="block text-sm font-medium text-gray-700 mb-2">
                        Sales End
                    </label>
                    <input type="datetime-local" 
                           id="sales_end" 
                           name="sales_end" 
                           value="{{ old('sales_end') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('sales_end') border-red-500 @enderror">
                    @error('sales_end')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Ticket Active</span>
                </label>
                <p class="text-sm text-gray-500 mt-1">Uncheck to create ticket as inactive</p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition">
                    Create Ticket
                </button>
                <a href="{{ route('organizer.events.tickets.index', $event) }}" 
                   class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-3 px-6 rounded-lg text-center transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection