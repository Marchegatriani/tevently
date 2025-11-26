@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('heading', 'Admin Dashboard')
@section('subheading', 'Ringkasan dan kontrol administrasi')

@section('header-actions')
	<a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md text-sm hover:bg-indigo-700">
		Manage Users
	</a>
@endsection

@section('content')
	<!-- Welcome -->
	<div class="mb-6">
		<div class="bg-indigo-50 border border-indigo-100 rounded-lg p-5">
			<h3 class="text-lg font-semibold text-indigo-700">Welcome, {{ auth()->user()->name }} 👋</h3>
			<p class="text-sm text-gray-600 mt-1">Anda memiliki akses penuh untuk mengelola sistem sebagai administrator.</p>
		</div>
	</div>

	<!-- Statistics -->
	<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
		<div class="bg-white border rounded-lg p-4 shadow-sm">
			<div class="flex items-center gap-4">
				<div class="bg-blue-500 text-white rounded-md p-3">
					<!-- icon -->
					<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z" /></svg>
				</div>
				<div>
					<p class="text-xs text-gray-500">Total Users</p>
					<p class="text-2xl font-semibold text-gray-800">{{ \App\Models\User::count() }}</p>
				</div>
			</div>
		</div>

		<div class="bg-white border rounded-lg p-4 shadow-sm">
			<div class="flex items-center gap-4">
				<div class="bg-yellow-500 text-white rounded-md p-3">
					<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
				</div>
				<div>
					<p class="text-xs text-gray-500">Pending Organizers</p>
					<p class="text-2xl font-semibold text-gray-800">{{ \App\Models\User::where('role', 'user')->where('status', 'pending')->count() }}</p>
				</div>
			</div>
		</div>

		<div class="bg-white border rounded-lg p-4 shadow-sm">
			<div class="flex items-center gap-4">
				<div class="bg-green-500 text-white rounded-md p-3">
					<svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
				</div>
				<div>
					<p class="text-xs text-gray-500">Total Events</p>
					<p class="text-2xl font-semibold text-gray-800">{{ \App\Models\Event::count() }}</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Quick Actions -->
	<div class="bg-white border rounded-lg p-4 shadow-sm">
		<h4 class="text-sm font-semibold text-gray-700 mb-3">Quick Actions</h4>
		<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
			<a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 border rounded hover:bg-gray-50">
				<div class="bg-indigo-600 text-white rounded p-2"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1z" /></svg></div>
				<div>
					<p class="text-sm font-medium">Manage Users</p>
					<p class="text-xs text-gray-500">Lihat dan kelola semua pengguna</p>
				</div>
			</a>

			<a href="#" class="flex items-center gap-3 p-3 border rounded hover:bg-gray-50">
				<div class="bg-purple-600 text-white rounded p-2"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></div>
				<div>
					<p class="text-sm font-medium">Manage Events</p>
					<p class="text-xs text-gray-500">Kelola acara dan tiket</p>
				</div>
			</a>

			<a href="#" class="flex items-center gap-3 p-3 border rounded hover:bg-gray-50">
				<div class="bg-pink-600 text-white rounded p-2"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z" /></svg></div>
				<div>
					<p class="text-sm font-medium">View Reports</p>
					<p class="text-xs text-gray-500">Laporan penjualan dan statistik</p>
				</div>
			</a>

			<a href="#" class="flex items-center gap-3 p-3 border rounded hover:bg-gray-50">
				<div class="bg-gray-600 text-white rounded p-2"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0" /></svg></div>
				<div>
					<p class="text-sm font-medium">Settings</p>
					<p class="text-xs text-gray-500">Konfigurasi sistem</p>
				</div>
			</a>
		</div>
	</div>
@endsection