@extends('layouts.app')
@section('title', 'Announcements')
@section('content')
    <div class="mb-6 px-6 flex flex-col md:flex-row gap-6">
        <!-- Post New Announcement Form -->
        <div class="bg-white rounded-md shadow-md overflow-hidden flex-grow md:w-2/3">
            <div class="h-1 bg-purple-800 w-full"></div>
            <div class="p-6">
                <h3 class="text-2xl font-semibold text-purple-700 mb-6">Add New Announcement</h3>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                
                <form id="announcement-form" action="{{ route('announcements.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Announcement Title</label>
                        <input type="text" name="announcement_title" placeholder="Enter announcement title"
                            class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Description</label>
                        <textarea name="description_text" rows="5" placeholder="Enter announcement description"
                            class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-purple-300" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Images (Maximum 5)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-md p-6 text-center cursor-pointer"
                            id="upload-container">
                            <span class="material-icons text-gray-400 text-3xl">file_upload</span>
                            <p class="mt-2">Click to upload images</p>
                            <p class="text-sm text-gray-500">PNG, JPG up to 10MB (Maximum 5 images)</p>
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
                            Post Announcement
                        </button>
                        <button type="reset"
                            class="bg-gray-200 text-gray-800 px-6 py-2 rounded-md hover:bg-gray-300 transition">
                            Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="bg-white p-6 rounded-lg shadow-md md:w-1/4 overflow-hidden">
            <h3 class="text-2xl font-semibold text-purple-700 mb-6">Recent Posts</h3>
            <div class="space-y-4">
                @foreach ($announcements as $announcement)
                    <div class="bg-gray-100 rounded-md">
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-800">{{ $announcement->announcement_title }}</h4>
                            <p class="text-sm text-gray-600">Posted on {{ date('d/m/Y', strtotime($announcement->created_at)) }}
                            </p>
                            <div class="flex justify-end mt-3 space-x-2">
                                <a href="{{ route('announcements.edit', $announcement->id) }}"
                                    class="bg-gray-200 text-gray-800 px-4 py-1 text-base rounded-md hover:bg-gray-300 transition">
                                    Edit
                                </a>
                                <button
                                    class="bg-red-600 text-white px-4 py-1 text-base rounded-md hover:bg-red-700 transition btn-delete"
                                    data-id="{{ $announcement->id }}">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- CSRF Token for JavaScript -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- JavaScript -->
    <script src="{{ asset('js/announcement.js') }}"></script>
@endsection