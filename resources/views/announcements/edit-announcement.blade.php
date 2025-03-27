@extends('layouts.app')
@section('title', 'Edit Announcement')
@section('content')

    <div class="bg-white rounded-md shadow-md p-6">
        <h3 class="text-2xl font-semibold text-purple-700 mb-6">Edit Announcement</h3>
        <form action="{{ route('announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Announcement Title</label>
                <input type="text" name="announcement_title" value="{{ $announcement->announcement_title }}"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Description</label>
                <textarea name="description_text" rows="5"
                    class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300"
                    required>{{ $announcement->description_text }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Existing Images</label>
                <div class="flex flex-wrap gap-4">
                    @if ($announcement->announcement_images)
                        @foreach (json_decode($announcement->announcement_images) as $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image) }}" alt="Announcement Image"
                                    class="w-24 h-24 object-cover rounded">
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">No images uploaded for this announcement.</p>
                    @endif
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Upload New Images</label>
                <div class="border-2 border-dashed border-gray-300 rounded-md p-6 text-center cursor-pointer"
                    id="upload-container" style="height: 200px;">
                    <span class="material-icons text-gray-400 text-3xl">file_upload</span>
                    <p class="mt-2">Click to upload images</p>
                    <p class="text-sm text-gray-500">PNG, JPG up to 10MB (Maximum 5 images)</p>
                    <input type="file" name="announcement_images[]" multiple class="hidden file-input" id="file-upload"
                        accept=".jpg,.jpeg,.png">
                </div>
                <p class="text-sm text-gray-500 mt-2">Leave blank if you don't want to update images.</p>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700 transition">
                    Update Announcement
                </button>
            </div>
        </form>
    </div>
@endsection