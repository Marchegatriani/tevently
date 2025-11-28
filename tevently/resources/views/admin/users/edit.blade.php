@extends('layouts.admin')

@section('title', 'Edit User')
@section('heading', 'Edit User')
@section('subheading', 'Perbarui Data User')

@section('header-actions')
    <a href="{{ route('admin.users.index') }}"
       class="inline-flex items-center px-3 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">
        Back to Users
    </a>
@endsection

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-sm rounded-lg p-6">

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 border border-red-300 px-4 py-3 rounded-md">
            <strong>There were some errors:</strong>
            <ul class="mt-2 text-sm list-disc ml-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   required>
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                   required>
        </div>

        <!-- Password (optional) -->
        <div>
            <label class="block text-sm font-medium text-gray-700">
                Password <span class="text-gray-400 text-sm">(Leave blank to keep current)</span>
            </label>
            <input type="password" name="password"
                   class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <!-- Role -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role"
                    class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="organizer" {{ $user->role === 'organizer' ? 'selected' : '' }}>Organizer</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status"
                    class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="" {{ $user->status == null ? 'selected' : '' }}>None</option>
                <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $user->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $user->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>

        <!-- Submit -->
        <div class="pt-4 flex gap-3">
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                Update User
            </button>

            <!-- Delete button -->
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                    Delete
                </button>
            </form>
        </div>

    </form>
</div>
@endsection