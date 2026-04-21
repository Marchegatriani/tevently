@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Profile Management</h2>

    <div class="space-y-8">
        {{-- Update Profile Information --}}
        <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Update Password --}}
        <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="p-4 sm:p-8 bg-white border border-gray-200 rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection