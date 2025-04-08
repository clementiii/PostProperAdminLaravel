@extends('layouts.app')
@section('title', 'Edit Announcement')
@section('content')
    <div class="mb-6 px-6">
        <div class="bg-white rounded-md shadow-md overflow-hidden">
            <div class="h-1 bg-purple-800 w-full"></div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <a href="{{ route('announcements.index') }}" class="text-purple-600 hover:text-purple-800 mr-4">
                        <span class="material-icons">arrow_back</span>
                    </a>
                    <h3 class="text-2xl font-semibold text-purple-700">Edit Announcement</h3>
                </div>
                
                <form id="announcement-form" action="{{ route('announcements.update', $announcement->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Announcement Title</label>
                        <input type="text" name="announcement_title" placeholder="Enter announcement title"
                            class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300" 
                            value="{{ $announcement->announcement_title }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea name="description_text" rows="5" placeholder="Enter announcement description"
                            class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300" 
                            required>{{ $announcement->description_text }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Current Images</label>
                        <div class="flex flex-wrap my-4">
                            @if($announcement->announcement_images)
                                @foreach(json_decode($announcement->announcement_images, true) as $index => $image)
                                    <div class="relative w-24 h-24 mr-2 mb-2">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                            alt="Announcement image {{ $index + 1 }}"
                                            class="w-full h-full object-cover rounded-md">
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500">No images uploaded</p>
                            @endif
                        </div>
                        
                        <label class="block text-gray-700 font-medium mb-2 mt-4">Replace Images (Maximum 5)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-md p-6 text-center cursor-pointer"
                            id="upload-container">
                            <span class="material-icons text-gray-400 text-3xl">file_upload</span>
                            <p class="mt-2">Click to upload new images</p>
                            <p class="text-sm text-gray-500">PNG, JPG up to 10MB (Maximum 5 images)</p>
                            <p class="text-sm text-red-500 mt-2">Uploading new images will replace all current images</p>
                            <input type="file" name="announcement_images[]" multiple class="hidden file-input"
                                id="file-upload" accept=".jpg,.jpeg,.png">
                        </div>
                        <!-- Image preview container -->
                        <div id="image-preview-container" class="mt-4 flex flex-wrap"></div>
                        <!-- Error message container -->
                        <div id="upload-error" class="text-red-500 mt-2 hidden"></div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700 transition mr-2 btn-save">
                            Update Announcement
                        </button>
                        <a href="{{ route('announcements.index') }}"
                            class="bg-gray-200 text-gray-800 px-6 py-2 rounded-md hover:bg-gray-300 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- JavaScript -->
    <script src="{{ asset('js/announcement.js') }}"></script>
@endsection