@extends('layouts.admin')

@section('title', 'Create Event')

@section('content')
<div class="container-fluid px-4">
    <h1 class="h3 mb-4">Create New Event</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label>Event Title *</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Description *</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Category *</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Max Attendees *</label>
                                    <input type="number" name="max_attendees" class="form-control" value="{{ old('max_attendees') }}" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Location *</label>
                            <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Event Date *</label>
                                    <input type="date" name="event_date" class="form-control" value="{{ old('event_date') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Start Time *</label>
                                    <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>End Time *</label>
                                    <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label>Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Event Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <div class="form-text">Max 2MB. JPG, PNG, JPEG</div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary w-100">Create Event</button>
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary w-100 mt-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection