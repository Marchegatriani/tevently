@extends('admin.partials.navbar')

@section('title', 'Events Report')
@section('heading', 'Events Report')
@section('subheading', 'Laporan performa setiap event')

@section('content')
<!-- Summary Info -->
<div class="mb-6 bg-indigo-50 border border-indigo-200 rounded-lg p-4">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm text-indigo-800">
            Menampilkan <strong>{{ $events->total() }}</strong> event dengan detail revenue dan jumlah order
        </p>
    </div>
</div>

<!-- Events Table -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Info</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organizer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Order Value</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($events as $event)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-start gap-3">
                        @if($event->image)
                        <img 
                            src="{{ asset('storage/' . $event->image) }}" 
                            alt="{{ $event->name }}"
                            class="w-16 h-16 object-cover rounded-lg"
                        >
                        @else
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $event->name }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($event->description, 50) }}</div>
                            <div class="text-xs text-gray-400 mt-1">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event->location }}
                                </span>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    {{ $event->organizer->name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ number_format($event->total_orders) }} orders
                    </span>
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-green-600">
                    Rp {{ number_format($event->total_revenue ?? 0, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    @if($event->total_orders > 0)
                        Rp {{ number_format(($event->total_revenue ?? 0) / $event->total_orders, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-2">Tidak ada data event</p>
                </td>
            </tr>
            @endforelse
        </tbody>
        
        <!-- Table Footer with Totals -->
        @if($events->count() > 0)
        <tfoot class="bg-gray-100">
            <tr>
                <td colspan="3" class="px-6 py-4 text-right font-semibold text-gray-900">
                    Total:
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-200 text-blue-900">
                        {{ number_format($events->sum('total_orders')) }} orders
                    </span>
                </td>
                <td class="px-6 py-4 text-sm font-bold text-green-700">
                    Rp {{ number_format($events->sum('total_revenue'), 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                    -
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

<!-- Pagination -->
@if($events->hasPages())
<div class="mt-6">
    {{ $events->links() }}
</div>
@endif
@endsection