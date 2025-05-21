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
                                @php
                                    $images = is_array($announcement->announcement_images) ? 
                                        $announcement->announcement_images : 
                                        json_decode($announcement->announcement_images, true);
                                    $images = is_array($images) ? $images : [];
                                @endphp
                                
                                @foreach($images as $index => $image)
                                    <div class="relative w-24 h-24 mr-2 mb-2">
                                        <img src="{{ $image }}" 
                                            alt="Announcement image {{ $index + 1 }}"
                                            class="w-full h-full object-cover rounded-md cursor-pointer"
                                            onclick="openImagePreviewModal('{{ $image }}')">
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
                        <button type="button" onclick="openUpdateModal()"
                            class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700 transition mr-2 btn-save">
                            Update Announcement
                        </button>
                        <button type="button" onclick="openCancelModal()"
                            class="bg-gray-200 text-gray-800 px-6 py-2 rounded-md hover:bg-gray-300 transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="cancel-modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 mb-6">
                    <span class="material-icons text-yellow-600 text-3xl">warning</span>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Discard Changes?</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to cancel? Any unsaved changes will be lost.</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hideCancelModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Go Back
                    </button>
                    <button type="button" id="confirmCancelBtn"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition">
                        Yes, Discard Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Confirmation Modal -->
    <div id="updateModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="update-modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-purple-100 mb-6">
                    <span class="material-icons text-purple-600 text-3xl">update</span>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm Update</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to update this announcement?</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hideUpdateModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="button" id="confirmUpdateBtn"
                        class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition">
                        Yes, Update Announcement
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- JavaScript -->
    <script src="{{ asset('js/announcement.js') }}"></script>
    
    <!-- Modal Scripts -->
    <script>
        // Cancel Modal Functions
        function openCancelModal() {
            const modal = document.getElementById('cancelModal');
            const modalContent = document.getElementById('cancel-modal-content');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Force a reflow before adding the transition classes
            void modalContent.offsetWidth;
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function hideCancelModal() {
            const modal = document.getElementById('cancelModal');
            const modalContent = document.getElementById('cancel-modal-content');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Re-enable scrolling
            }, 200);
        }

        // Update Modal Functions
        function openUpdateModal() {
            // Validate form before showing modal
            const form = document.getElementById('announcement-form');
            if (!form.checkValidity()) {
                // If form is not valid, trigger browser validation UI
                form.reportValidity();
                return;
            }
            
            const modal = document.getElementById('updateModal');
            const modalContent = document.getElementById('update-modal-content');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
            
            // Force a reflow before adding the transition classes
            void modalContent.offsetWidth;
            
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function hideUpdateModal() {
            const modal = document.getElementById('updateModal');
            const modalContent = document.getElementById('update-modal-content');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = ''; // Re-enable scrolling
            }, 200);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Cancel button handlers
            const confirmCancelBtn = document.getElementById('confirmCancelBtn');
            if (confirmCancelBtn) {
                confirmCancelBtn.addEventListener('click', function() {
                    window.location.href = "{{ route('announcements.index') }}";
                });
            }
            
            const cancelModal = document.getElementById('cancelModal');
            if (cancelModal) {
                cancelModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideCancelModal();
                    }
                });
            }
            
            // Update button handlers
            const confirmUpdateBtn = document.getElementById('confirmUpdateBtn');
            if (confirmUpdateBtn) {
                confirmUpdateBtn.addEventListener('click', function() {
                    document.getElementById('announcement-form').submit();
                });
            }
            
            const updateModal = document.getElementById('updateModal');
            if (updateModal) {
                updateModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        hideUpdateModal();
                    }
                });
            }
        });
    </script>
    
    <style>
        /* Additional modal styles */
        #cancel-modal-content, #update-modal-content {
            display: block;
            position: relative;
            z-index: 60;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        
        /* Ensure modals are visible */
        #cancelModal.flex #cancel-modal-content,
        #updateModal.flex #update-modal-content {
            opacity: 1;
        }
        
        /* Force hardware acceleration for smoother animations */
        .transform {
            will-change: transform, opacity;
            backface-visibility: hidden;
        }
    </style>
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