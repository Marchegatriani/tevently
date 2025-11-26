@extends('layouts.user')

@section('title', 'Favorit Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Favorit Saya</h1>
    
    @if(count($favorites) > 0)
        <div class="grid grid-cols-3 gap-6">
            @foreach($favorites as $event)
                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-bold">{{ $event->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $event->date }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Belum ada event favorit.</p>
    @endif
</div>
@endsection