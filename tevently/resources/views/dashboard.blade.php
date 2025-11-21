<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @auth
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-2">Welcome, {{ auth()->user()->name }}!</h3>
                        <p class="text-gray-600">You're logged in!</p>
                    </div>
                </div>

                <!-- Become Organizer Section -->
                @if(auth()->user()->role === 'user')
                    <div class="mt-6 bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg border border-blue-200">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-blue-900 mb-2">
                                🎉 Want to Create Your Own Events?
                            </h3>
                            <p class="text-gray-700 mb-4">
                                Become an Event Organizer and start creating and managing your own events!
                            </p>
                            <form method="POST" action="{{ route('organizer.request') }}">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Become an Organizer
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Organizer Status Section -->
                @if(auth()->user()->role === 'organizer')
                    <div class="mt-6 bg-yellow-50 overflow-hidden shadow-sm sm:rounded-lg border border-yellow-200">
                        <div class="p-6">
                            @if(auth()->user()->status === 'pending')
                                <h3 class="text-lg font-semibold text-yellow-900 mb-2">
                                    ⏳ Organizer Request Pending
                                </h3>
                                <p class="text-gray-700">
                                    Your request to become an Event Organizer is being reviewed by our admin team. 
                                    You will be notified once your account is approved.
                                </p>
                            @elseif(auth()->user()->status === 'approved')
                                <h3 class="text-lg font-semibold text-green-900 mb-2">
                                    ✅ You're an Approved Organizer!
                                </h3>
                                <p class="text-gray-700 mb-4">
                                    Your organizer account is active. You can now create and manage events.
                                </p>
                                <a href="{{ route('organizer.dashboard') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">
                                    Go to Organizer Dashboard
                                </a>
                            @elseif(auth()->user()->status === 'rejected')
                                <h3 class="text-lg font-semibold text-red-900 mb-2">
                                    ❌ Organizer Request Rejected
                                </h3>
                                <p class="text-gray-700 mb-4">
                                    Unfortunately, your request to become an Event Organizer has been rejected. 
                                    Please contact support for more information.
                                </p>
                                <form method="POST" action="{{ route('organizer.request') }}">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Re-apply as Organizer
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</x-app-layout>