document.addEventListener('DOMContentLoaded', function() {
    // Image upload handling
    const uploadContainer = document.getElementById('upload-container');
    const fileInput = document.getElementById('file-upload');
    const previewContainer = document.getElementById('image-preview-container');
    const errorContainer = document.getElementById('upload-error');
    const MAX_FILES = 5;
    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB in bytes
    
    // Click on the upload container to trigger file input
    if (uploadContainer) {
        uploadContainer.addEventListener('click', function() {
            fileInput.click();
        });
    }
    
    // Handle file selection
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const files = this.files;
            
            // Clear previous previews and errors
            previewContainer.innerHTML = '';
            errorContainer.textContent = '';
            errorContainer.classList.add('hidden');
            
            // Validate number of files
            if (files.length > MAX_FILES) {
                errorContainer.textContent = `Maximum ${MAX_FILES} images allowed`;
                errorContainer.classList.remove('hidden');
                fileInput.value = '';
                return;
            }
            
            // Validate file types and sizes
            let hasInvalidFile = false;
            Array.from(files).forEach(file => {
                const fileType = file.type.toLowerCase();
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                
                if (!validTypes.includes(fileType)) {
                    errorContainer.textContent = 'Only JPG and PNG images are allowed';
                    errorContainer.classList.remove('hidden');
                    hasInvalidFile = true;
                } else if (file.size > MAX_FILE_SIZE) {
                    errorContainer.textContent = 'Images must be under 10MB';
                    errorContainer.classList.remove('hidden');
                    hasInvalidFile = true;
                }
            });
            
            if (hasInvalidFile) {
                fileInput.value = '';
                return;
            }
            
            // Create previews for valid files
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewWrapper = document.createElement('div');
                    previewWrapper.className = 'relative w-24 h-24 mr-2 mb-2';
                    
                    const previewImage = document.createElement('img');
                    previewImage.src = e.target.result;
                    previewImage.className = 'w-full h-full object-cover rounded-md';
                    
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center';
                    removeButton.innerHTML = '×';
                    removeButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        previewWrapper.remove();
                        
                        // Create a new FileList without the removed file
                        // Unfortunately, FileList is immutable, so we need to reset the input
                        // This is a limitation and in production you might need a different approach
                        fileInput.value = '';
                    });
                    
                    previewWrapper.appendChild(previewImage);
                    previewWrapper.appendChild(removeButton);
                    previewContainer.appendChild(previewWrapper);
                };
                
                reader.readAsDataURL(file);
            });
        });
    }
    
    // Delete announcement handling
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const announcementId = this.getAttribute('data-id');
            
            if (confirm('Are you sure you want to delete this announcement?')) {
                // Send delete request
                fetch(`/announcements/${announcementId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        // Reload page to reflect changes
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the announcement.');
                });
            }
        });
    });
});