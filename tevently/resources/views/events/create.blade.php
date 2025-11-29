@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.organizer')

@section('title', 'Create Event')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Create Event & Tickets</h1>
            <p class="text-gray-600">Create new event with multiple ticket types</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg">
            <form action="{{ Auth::user()->role === 'admin' ? route('admin.events.store') : route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <!-- Event Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-md border-gray-300" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select name="category_id" class="w-full rounded-md border-gray-300" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                        <input type="text" name="location" value="{{ old('location') }}" class="w-full rounded-md border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Max Attendees *</label>
                        <input type="number" name="max_attendees" value="{{ old('max_attendees') }}" min="1" class="w-full rounded-md border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Date *</label>
                        <input type="date" name="event_date" value="{{ old('event_date') }}" min="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Time *</label>
                            <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">End Time *</label>
                            <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full rounded-md border-gray-300" required>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" rows="3" class="w-full rounded-md border-gray-300" required>{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300">
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full rounded-md border-gray-300">
                    </div>
                </div>

                <!-- Tickets Section -->
                <div class="border-t pt-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Tickets</h2>
                    
                    <div id="tickets-container">
                        <!-- Default first ticket -->
                        <div class="ticket-item bg-gray-50 p-4 rounded-lg mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ticket Name *</label>
                                    <input type="text" name="tickets[0][name]" class="w-full rounded-md border-gray-300" placeholder="Regular Ticket" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) *</label>
                                    <input type="number" name="tickets[0][price]" min="0" class="w-full rounded-md border-gray-300" placeholder="50000" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                    <input type="number" name="tickets[0][quantity_available]" min="1" class="w-full rounded-md border-gray-300" placeholder="100" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Per Order</label>
                                    <input type="number" name="tickets[0][max_per_order]" min="1" value="5" class="w-full rounded-md border-gray-300">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="tickets[0][description]" rows="2" class="w-full rounded-md border-gray-300" placeholder="Ticket description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="addTicket()" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300">
                        + Add Another Ticket
                    </button>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 mt-8">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                        Create Event & Tickets
                    </button>
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.events.index') : route('organizer.events.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let ticketCount = 1;

function addTicket() {
    const container = document.getElementById('tickets-container');
    const newTicket = document.createElement('div');
    newTicket.className = 'ticket-item bg-gray-50 p-4 rounded-lg mb-4';
    newTicket.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ticket Name *</label>
                <input type="text" name="tickets[${ticketCount}][name]" class="w-full rounded-md border-gray-300" placeholder="VIP Ticket" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price (Rp) *</label>
                <input type="number" name="tickets[${ticketCount}][price]" min="0" class="w-full rounded-md border-gray-300" placeholder="100000" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                <input type="number" name="tickets[${ticketCount}][quantity_available]" min="1" class="w-full rounded-md border-gray-300" placeholder="50" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Max Per Order</label>
                <input type="number" name="tickets[${ticketCount}][max_per_order]" min="1" value="5" class="w-full rounded-md border-gray-300">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="tickets[${ticketCount}][description]" rows="2" class="w-full rounded-md border-gray-300" placeholder="Ticket description"></textarea>
            </div>
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="mt-2 text-red-600 text-sm hover:text-red-800">
            Remove Ticket
        </button>
    `;
    container.appendChild(newTicket);
    ticketCount++;
}
</script>
@endsection