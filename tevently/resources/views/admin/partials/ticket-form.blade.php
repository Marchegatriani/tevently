<div class="ticket-item bg-gray-50 p-4 rounded-lg mb-4 border">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
            <input type="text" name="tickets[{{ $index }}][name]" 
                   value="{{ old("tickets.$index.name", $ticket->name ?? 'Regular') }}" 
                   class="w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price *</label>
            <input type="number" name="tickets[{{ $index }}][price]" 
                   value="{{ old("tickets.$index.price", $ticket->price ?? 50000) }}" 
                   min="0" class="w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
            <input type="number" name="tickets[{{ $index }}][quantity_available]" 
                   value="{{ old("tickets.$index.quantity_available", $ticket->quantity_available ?? 100) }}" 
                   min="1" class="w-full rounded-md border-gray-300" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Max/Order</label>
            <input type="number" name="tickets[{{ $index }}][max_per_order]" 
                   value="{{ old("tickets.$index.max_per_order", $ticket->max_per_order ?? 5) }}" 
                   min="1" class="w-full rounded-md border-gray-300">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="tickets[{{ $index }}][description]" rows="2" 
                      class="w-full rounded-md border-gray-300">{{ old("tickets.$index.description", $ticket->description ?? '') }}</textarea>
        </div>
    </div>
    
    @if(isset($removable) && $removable)
    <div class="flex justify-end mt-2">
        <button type="button" onclick="this.closest('.ticket-item').remove()" 
                class="text-red-600 hover:text-red-800 text-sm">Remove</button>
    </div>
    @endif
</div>