@extends('admin.partials.navbar')

@section('title', 'Users Report')
@section('heading', 'Users Report')
@section('subheading', 'Laporan aktivitas dan spending pengguna')

@section('content')
<!-- Summary Info -->
<div class="mb-6 bg-purple-50 border border-purple-200 rounded-lg p-4">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p class="text-sm text-purple-800">
            Menampilkan <strong>{{ $users->total() }}</strong> pengguna yang pernah melakukan pembelian
        </p>
    </div>
</div>

<!-- Users Table -->
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Spent</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Order Value</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Since</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            @if($user->total_spent >= 5000000)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    VIP Customer
                                </span>
                            @elseif($user->total_orders >= 5)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    Regular Customer
                                </span>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ number_format($user->total_orders) }}
                        </span>
                        @if($user->total_orders >= 10)
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-semibold text-green-600">
                        Rp {{ number_format($user->total_spent ?? 0, 0, ',', '.') }}
                    </div>
                    <!-- Progress bar -->
                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                        <div 
                            class="bg-green-600 h-1.5 rounded-full" 
                            style="width: {{ min(($user->total_spent / 10000000) * 100, 100) }}%"
                        ></div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">
                    @if($user->total_orders > 0)
                        Rp {{ number_format(($user->total_spent ?? 0) / $user->total_orders, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $user->created_at->format('d M Y') }}
                    <div class="text-xs text-gray-400">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="mt-2">Tidak ada data pengguna dengan pembelian</p>
                </td>
            </tr>
            @endforelse
        </tbody>
        
        <!-- Table Footer with Totals -->
        @if($users->count() > 0)
        <tfoot class="bg-gray-100">
            <tr>
                <td colspan="2" class="px-6 py-4 text-right font-semibold text-gray-900">
                    Total:
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-200 text-blue-900">
                        {{ number_format($users->sum('total_orders')) }} orders
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-bold text-green-700">
                        Rp {{ number_format($users->sum('total_spent'), 0, ',', '.') }}
                    </div>
                </td>
                <td colspan="2" class="px-6 py-4">
                    -
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

<!-- Pagination -->
@if($users->hasPages())
<div class="mt-6">
    {{ $users->links() }}
</div>
@endif

<!-- Customer Insights -->
@if($users->count() > 0)
<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-purple-900 mb-2">Top Spender</h3>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr($users->first()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900">{{ $users->first()->name }}</p>
                <p class="text-xs text-green-600 font-semibold">Rp {{ number_format($users->first()->total_spent, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-blue-900 mb-2">Average Order Value</h3>
        <p class="text-2xl font-bold text-blue-600">
            Rp {{ number_format($users->sum('total_spent') / max($users->sum('total_orders'), 1), 0, ',', '.') }}
        </p>
        <p class="text-xs text-gray-500 mt-1">Per transaction</p>
    </div>
    
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <h3 class="text-sm font-semibold text-green-900 mb-2">Active Customers</h3>
        <p class="text-2xl font-bold text-green-600">{{ $users->total() }}</p>
        <p class="text-xs text-gray-500 mt-1">Users with purchases</p>
    </div>
</div>
@endif
@endsection