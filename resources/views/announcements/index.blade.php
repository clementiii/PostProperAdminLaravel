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
                            <p class="text-sm text-gray-500">PNG, JPG, JPEG up to 10MB (Maximum 5 images)</p>
                            <input type="file" name="announcement_images[]" multiple class="hidden file-input"
                                id="file-upload" accept="image/jpeg,image/jpg,image/png">
                        </div>
                        <!-- Image preview container -->
                        <div id="image-preview-container" class="mt-4 flex flex-wrap"></div>
                        <!-- Error message container -->
                        <div id="upload-error" class="text-red-500 mt-2 hidden"></div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" onclick="openPostModal()"
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
                            <p class="text-sm text-gray-600">Posted on {{ \Carbon\Carbon::parse($announcement->created_at)->format('F d, Y h:i A') }}
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

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <span class="material-icons text-red-600 text-3xl">delete</span>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm Deletion</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to delete this announcement? This action cannot be undone.</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" id="cancelDeleteBtn" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="button" id="confirmDeleteBtn"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Post Confirmation Modal -->
    <div id="postModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="post-modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-purple-100 mb-6">
                    <span class="material-icons text-purple-600 text-3xl">campaign</span>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm Post</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to post this announcement?</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hidePostModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="button" id="confirmPostBtn"
                        class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">
                        Yes, Post Announcement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- CSRF Token for JavaScript -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Additional CSS for modal -->
    <style>
        /* Modal animation styles */
        #modal-content {
            display: block;
            position: relative;
            z-index: 60;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        
        /* Ensure modal is visible */
        #deleteModal.flex #modal-content {
            opacity: 1;
        }
        
        /* Force hardware acceleration for smoother animations */
        .transform {
            will-change: transform, opacity;
            backface-visibility: hidden;
        }
    </style>

    <!-- JavaScript -->
    <script src="{{ asset('js/announcement.js') }}"></script>
    
    <!-- Post Modal Script -->
    <script>
        function openPostModal() {
            // Validate form before showing modal
            const form = document.getElementById('announcement-form');
            if (!form.checkValidity()) {
                // If form is not valid, trigger browser validation UI
                form.reportValidity();
                return;
            }
            
            const modal = document.getElementById('postModal');
            const modalContent = document.getElementById('post-modal-content');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Force a reflow before adding the transition classes
            void modalContent.offsetWidth;
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function hidePostModal() {
            const modal = document.getElementById('postModal');
            const modalContent = document.getElementById('post-modal-content');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Re-enable scrolling
            }, 200);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Confirm post button click handler
            const confirmPostBtn = document.getElementById('confirmPostBtn');
            if (confirmPostBtn) {
                confirmPostBtn.addEventListener('click', function() {
                    document.getElementById('announcement-form').submit();
                });
            }
            
            // Close modal when clicking outside
            const postModal = document.getElementById('postModal');
            if (postModal) {
                postModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hidePostModal();
                    }
                });
            }
        });
    </script>
    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="relative bg-white rounded-lg shadow-xl p-2 max-w-4xl max-h-full m-4 overflow-auto transform transition-all">
            <button type="button" onclick="hideImagePreviewModal()" class="absolute top-1 right-1 text-gray-500 hover:text-gray-700 z-50 bg-white rounded-full p-1">
                <span class="material-icons">close</span>
            </button>
            <img id="previewModalImage" src="" alt="Image Preview" class="max-h-[80vh] max-w-full object-contain">
        </div>
    </div>
    
    <!-- Image Preview Script -->
    <script>
        function openImagePreviewModal(imageUrl) {
            const modal = document.getElementById('imagePreviewModal');
            const modalImage = document.getElementById('previewModalImage');
            
            // Set image source
            modalImage.src = imageUrl;
            
            // Show modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }
        
        function hideImagePreviewModal() {
            const modal = document.getElementById('imagePreviewModal');
            
            // Hide modal
            modal.classList.add('hidden');
            document.body.style.overflow = ''; // Re-enable scrolling
        }
        
        // Close modal when clicking outside the image
        document.addEventListener('DOMContentLoaded', function() {
            const imagePreviewModal = document.getElementById('imagePreviewModal');
            if (imagePreviewModal) {
                imagePreviewModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideImagePreviewModal();
                    }
                });
            }
            
            // Add click event to all existing preview images
            const previewImages = document.querySelectorAll('#image-preview-container img');
            previewImages.forEach(img => {
                img.classList.add('cursor-pointer');
                img.addEventListener('click', function() {
                    openImagePreviewModal(this.src);
                });
            });
        });
    </script>
@endsection