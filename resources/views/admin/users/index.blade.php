@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('heading', 'Kelola Pengguna')
@section('subheading', 'Ringkasan dan kontrol pengguna sistem')

@section('header-actions')
@endsection

@section('content')
<style>
    .text-custom-dark { color: #250e2c; }
    .bg-main-purple { background-color: #837ab6; }
    .bg-pink-accent { background-color: #cc8db3; }
    .bg-soft-pink-light { background-color: #f7c2ca; }
</style>

<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-xl relative font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-xl relative font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if($pendingCount > 0)
            <div class="mb-6 bg-yellow-50 border border-yellow-300 rounded-xl p-4 shadow-sm">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-yellow-800 font-semibold">
                        {{ $pendingCount }} permintaan organizer menunggu persetujuan.
                    </span>
                </div>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl rounded-2xl mb-6 border border-gray-100">
            <div class="p-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-custom-dark mb-1">Cari</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Nama atau email..." 
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-main-purple focus:ring-main-purple transition bg-gray-50 px-4 py-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-custom-dark mb-1">Role</label>
                            <select name="role" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-main-purple focus:ring-main-purple transition bg-gray-50 px-4 py-2">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="organizer" {{ request('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-custom-dark mb-1">Status</label>
                            <select name="status" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-main-purple focus:ring-main-purple transition bg-gray-50 px-4 py-2">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="bg-main-purple hover:bg-[#9d85b6] text-white font-semibold px-4 py-2 rounded-xl shadow-md transition">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-200 hover:bg-gray-300 text-custom-dark font-semibold px-4 py-2 rounded-xl transition">
                            Hapus Filter
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-soft-pink-light">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-custom-dark uppercase tracking-wider">Bergabung</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-custom-dark uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-main-purple/20 flex items-center justify-center">
                                                    <span class="text-main-purple font-semibold text-sm">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-custom-dark">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->role === 'admin' ? 'bg-pink-accent/20 text-pink-accent' : '' }}
                                            {{ $user->role === 'organizer' ? 'bg-main-purple/20 text-main-purple' : '' }}
                                            {{ $user->role === 'user' ? 'bg-gray-200 text-gray-700' : '' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->status)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $user->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $user->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $user->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($user->status === 'pending')
                                            <div class="flex justify-end gap-3">
                                                <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-green-600 hover:text-green-800 font-semibold transition">
                                                        Setujui
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.users.reject', $user) }}" 
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menolak permintaan organizer ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold transition">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 text-lg">
                                        Tidak ada pengguna ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection