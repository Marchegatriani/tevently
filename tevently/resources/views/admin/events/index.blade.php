@extends('layouts.admin')

@section('title', 'Manage Events')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Manage Events</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            + Create Event
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Event</th>
                            <th>Organizer</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($event->image_url)
                                        <img src="{{ asset('storage/' . $event->image_url) }}" 
                                             alt="{{ $event->title }}" 
                                             class="rounded me-3" width="40" height="40">
                                    @endif
                                    <div>
                                        <strong>{{ $event->title }}</strong>
                                        <div class="text-muted small">{{ $event->category->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $event->organizer->name }}</td>
                            <td>{{ $event->event_date->format('M d, Y') }}</td>
                            <td>{{ Str::limit($event->location, 20) }}</td>
                            <td>
                                <span class="badge bg-{{ $event->status === 'published' ? 'success' : ($event->status === 'draft' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($event->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Delete this event?')">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection