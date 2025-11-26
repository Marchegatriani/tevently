@extends('layouts.admin')

@section('title', $event->title)

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">{{ $event->title }}</h1>
        <div>
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    @if($event->image_url)
                        <img src="{{ asset('storage/' . $event->image_url) }}" alt="{{ $event->title }}" class="img-fluid rounded mb-3">
                    @endif
                    
                    <p><strong>Description:</strong></p>
                    <p>{{ $event->description }}</p>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <p><strong>Category:</strong> {{ $event->category->name }}</p>
                            <p><strong>Location:</strong> {{ $event->location }}</p>
                            <p><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Time:</strong> {{ $event->start_time->format('h:i A') }} - {{ $event->end_time->format('h:i A') }}</p>
                            <p><strong>Max Attendees:</strong> {{ number_format($event->max_attendees) }}</p>
                            <p><strong>Organizer:</strong> {{ $event->organizer->name }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $event->status === 'published' ? 'success' : 'warning' }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Event Statistics</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tickets:</strong> {{ $event->tickets->count() }}</p>
                    <p><strong>Total Quota:</strong> {{ $event->tickets->sum('quota') }}</p>
                    <p><strong>Tickets Sold:</strong> {{ $event->tickets->sum('quantity_sold') }}</p>
                    <hr>
                    <p><strong>Created:</strong> {{ $event->created_at->format('M d, Y') }}</p>
                    <p><strong>Last Updated:</strong> {{ $event->updated_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection