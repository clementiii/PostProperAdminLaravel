@extends('layouts.app')

@section('title', 'Announcements')

@section('content')

<div class="p-6">
    <!-- Post New Announcement Form -->
    <div class="bg-white p-6 rounded-md shadow-md">
        <h3 class="text-lg font-semibold text-purple-700 mb-4">Post New Announcement</h3>
        <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Title</label>
                <input type="text" name="announcement_title" class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Description</label>
                <textarea name="description_text" class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300" required></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Upload Images</label>
                <input type="file" name="announcement_images[]" multiple class="w-full px-4 py-2 border rounded-md">
            </div>
            <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition">Post</button>
        </form>
    </div>

    <!-- Recent Announcements -->
    <div class="mt-6 bg-white p-6 rounded-md shadow-md">
        <h3 class="text-xl font-semibold text-purple-700 mb-4">Recent Announcements</h3>
        <div class="space-y-4">
            @foreach ($announcements as $announcement)
                <div class="p-4 border rounded-md shadow-md">
                    <h4 class="text-lg font-semibold text-purple-700">{{ $announcement->announcement_title }}</h4>
                    <p class="text-gray-600">{{ $announcement->description_text }}</p>
                    
                    @php
                        $images = json_decode($announcement->announcement_images, true);
                    @endphp

                    @if ($images && is_array($images))
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach ($images as $image)
                                <img src="{{ url('assets/uploads/announcements/' . basename($image)) }}" class="w-32 h-32 object-cover rounded-md shadow-md">
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="{{ asset('js/announcement.js') }}"></script>
@endsection
