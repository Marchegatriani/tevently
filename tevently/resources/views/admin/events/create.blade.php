@extends('admin.partials.sidebar')

@section('title', 'Create Event')

@section('content')
<main class="flex-1 p-0 px-2">
  <div class="bg-white shadow-md rounded-lg p-8">
    <h2 class="text-3xl font-bold mb-8 text-[#1B1464]">Create Event</h2>
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      @csrf
      
      <!-- Image Upload (Left Section) -->
      <div class="flex flex-col items-center">
        <label for="image" class="block text-gray-700 font-medium mb-4">Event Image</label>
        <div class="relative">
          <img id="image-preview" 
            src="https://via.placeholder.com/300x200/1B1464/FFFFFF?text=Upload+Image" 
            alt="Event Image" 
            class="h-48 w-full rounded-lg border object-cover cursor-pointer shadow-lg mb-4" 
            onclick="document.getElementById('image').click();">
          <input type="file" id="image" name="image" class="hidden" onchange="previewEventImage(event);">
        </div>
        <p class="text-gray-500 text-sm text-center">Click the image to upload (Max 2MB)</p>
        @error('image')
          <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
      </div>
      
      <!-- Form Fields (Right Section) -->
      <div class="col-span-2 space-y-4">
        <!-- Title Input -->
        <div>
          <label for="title" class="block text-gray-700 font-medium mb-2">Title <span class="text-red-500">*</span></label>
          <input type="text" id="title" name="title" value="{{ old('title') }}"
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
            placeholder="Enter event title" required>
          @error('title')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>
        
        <!-- Description Input -->
        <div>
          <label for="description" class="block text-gray-700 font-medium mb-2">Description <span class="text-red-500">*</span></label>
          <textarea id="description" name="description" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
            rows="3" placeholder="Describe your event" required>{{ old('description') }}</textarea>
          @error('description')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <!-- Category Selection -->
        <div>
          <label for="category_id" class="block text-gray-700 font-medium mb-2">Category <span class="text-red-500">*</span></label>
          <select id="category_id" name="category_id" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
            required>
            <option value="" disabled selected>Select a category</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <!-- Date & Time Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="event_date" class="block text-gray-700 font-medium mb-2">Event Date <span class="text-red-500">*</span></label>
            <input type="date" id="event_date" name="event_date" value="{{ old('event_date') }}"
              min="{{ date('Y-m-d') }}"
              class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
              required>
            @error('event_date')
              <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
          </div>
          <div class="grid grid-cols-2 gap-2">
            <div>
              <label for="start_time" class="block text-gray-700 font-medium mb-2">Start Time <span class="text-red-500">*</span></label>
              <input type="time" id="start_time" name="start_time" value="{{ old('start_time', '19:00') }}"
                class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
                required>
            </div>
            <div>
              <label for="end_time" class="block text-gray-700 font-medium mb-2">End Time <span class="text-red-500">*</span></label>
              <input type="time" id="end_time" name="end_time" value="{{ old('end_time', '22:00') }}"
                class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
                required>
            </div>
          </div>
        </div>

        <!-- Location Input -->
        <div>
          <label for="location" class="block text-gray-700 font-medium mb-2">Location <span class="text-red-500">*</span></label>
          <input type="text" id="location" name="location" value="{{ old('location') }}"
            placeholder="e.g. Grand Ballroom, Hotel XYZ, Jakarta"
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
            required>
          @error('location')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <!-- Max Attendees Input -->
        <div>
          <label for="max_attendees" class="block text-gray-700 font-medium mb-2">Max Attendees <span class="text-red-500">*</span></label>
          <input type="number" id="max_attendees" name="max_attendees" value="{{ old('max_attendees', 50) }}"
            min="1"
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]"
            required>
          @error('max_attendees')
            <span class="text-red-500 text-xs">{{ $message }}</span>
          @enderror
        </div>

        <!-- Status Selection -->
        <div>
          <label for="status" class="block text-gray-700 font-medium mb-2">Status</label>
          <select id="status" name="status" 
            class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#640D5F]">
            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publish Now</option>
          </select>
          <p class="text-gray-500 text-sm mt-1">
            <strong>Note:</strong> After creating the event, you'll be redirected to add tickets.
          </p>
        </div>
        
        <!-- Submit Buttons -->
        <div class="flex justify-between space-x-4 pt-4">
          <button type="submit" 
            class="flex-1 bg-[#640D5F] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#4a0a47] transition duration-300">
            Create Event & Add Tickets
          </button>
          <a href="{{ route('admin.events.index') }}" 
            class="flex-1 text-center bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-400 transition duration-300">
            Cancel
          </a>
        </div>
      </div>
    </form>
  </div>
</main>

<script>
  function previewEventImage(event) {
    const preview = document.getElementById('image-preview');
    const file = event.target.files[0];
    if (file) {
      preview.src = URL.createObjectURL(file);
    }
  }

  // Set minimum time for end_time based on start_time
  document.getElementById('start_time').addEventListener('change', function() {
    const endTime = document.getElementById('end_time');
    endTime.min = this.value;
    
    // If end_time is before start_time, reset it
    if (endTime.value && endTime.value < this.value) {
      endTime.value = '';
    }
  });
</script>
@endsection