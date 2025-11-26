@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.organizer')

@section('title', 'Manage Tickets - ' . $event->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="text-sm text-gray-600">
            <a href="{{ route('organizer.events.index') }}" class="hover:text-blue-600">My Events</a>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800">{{ $event->title }}</span>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800">Tickets</span>
        </nav>
    </div>

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Ticket Management</h1>
            <p class="text-gray-600 mt-1">Kelola tiket untuk event: <strong>{{ $event->name }}</strong></p>
        </div>
        <a href="{{ route('organizer.events.tickets.create', $event) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
            + Create New Ticket
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tickets List -->
    @if($tickets->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum ada tiket</h3>
            <p class="text-gray-500 mb-4">Buat tiket pertama Anda untuk event ini</p>
            <a href="{{ route('organizer.events.tickets.create', $event) }}" 
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Create Ticket
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Available</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sold</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tickets as $ticket)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $ticket->name }}</div>
                                @if($ticket->description)
                                    <div class="text-sm text-gray-500">{{ Str::limit($ticket->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                Rp {{ number_format($ticket->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $ticket->quantity_available }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-700">{{ $ticket->quantity_sold }}</div>
                                <div class="text-xs text-gray-500">Remaining: {{ $ticket->quantity_available - $ticket->quantity_sold }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($ticket->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $ticket->getAvailabilityStatus() }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <!-- Toggle Active -->
                                    <form action="{{ route('organizer.events.tickets.toggle', [$event, $ticket]) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-yellow-600 hover:text-yellow-800"
                                                title="{{ $ticket->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            @if($ticket->is_active)
                                                👁️
                                            @else
                                                👁️‍🗨️
                                            @endif
                                        </button>
                                    </form>

                                    <!-- Edit -->
                                    <a href="{{ route('organizer.events.tickets.edit', [$event, $ticket]) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        ✏️
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('organizer.events.tickets.destroy', [$event, $ticket]) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection