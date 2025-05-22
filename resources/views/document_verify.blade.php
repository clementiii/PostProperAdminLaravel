<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document Verification</title>
    <link rel="icon" href="{{ asset('/assets/Southside.png') }}" type="image/png">
    {{-- Include Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">
    {{-- Include Bootstrap CSS and JS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Include jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- Include Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    {{-- Add any specific CSS for this page if needed --}}
    <style>
        /* Basic styling for info items if needed */
        .info-item strong {
            display: inline-block;
            width: 120px;
            /* Adjust as needed */
            font-weight: 600;
        }

        .info-item span {
            color: #555;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #4a5568;
            /* gray-700 */
            border-bottom: 1px solid #e2e8f0;
            /* gray-300 */
            padding-bottom: 0.5rem;
        }

        .zoomable {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .zoomable:hover {
            transform: scale(1.02);
        }

        /* Modal styles */
        .custom-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto;
        }

        .custom-modal-content {
            background-color: white;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .custom-modal-close {
            position: absolute;
            top: 10px;
            right: 16px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
            color: #666;
            transition: color 0.2s;
        }
        
        .custom-modal-close:hover {
            color: #000;
        }

        #imageModalContent {
            max-width: 90%;
            max-height: 90vh;
        }

        #confirmModalContent {
            width: 400px;
            max-width: 90%;
        }

        .modal-header {
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 15px;
            position: relative;
        }

        .modal-footer {
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        body.modal-open {
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100">

    @extends('layouts.app')

    @section('title', 'Document Verification')

    @section('content')
        <div class="p-6 space-y-6">

            <div class="document-header mb-4 flex justify-between items-center">
                {{-- Back button using JS history or link to index --}}
                <a href="{{ route('documents.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-150 ease-in-out text-sm">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
                <h2 class="text-2xl font-semibold text-purple-800 text-center flex-grow">Document Verification
                    (TXN-{{ $documentRequest->Id }})</h2>
                {{-- Empty div to maintain layout balance --}}
                <div class="w-[80px]"></div>
            </div>

            {{-- Display Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Validation Error!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {{-- Display Success Message from Redirect --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif


            <div class="verification-container bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-1 bg-purple-800"></div> {{-- Purple Top Border --}}
                <div class="p-6 space-y-6">
                    {{-- Personal and Additional Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border rounded-lg p-4">
                            <h5 class="text-2xl font-semibold text-purple-700 mb-4">Personal Details</h5>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Name:</p>
                                        <p class="font-medium">{{ $documentRequest->Name }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Address:</p>
                                        <p class="font-medium">{{ $documentRequest->Address ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Age:</p>
                                        <p class="font-medium">{{ $documentRequest->Age }} years old</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Date of Birth:</p>
                                        <p class="font-medium">{{ $documentRequest->birthday ? \Carbon\Carbon::createFromFormat('m-d-y', $documentRequest->birthday)->format('F d, Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Place of Birth:</p>
                                        <p class="font-medium">{{ $documentRequest->PlaceOfBirth ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Alias:</p>
                                        <p class="font-medium">{{ $documentRequest->Alias ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded-lg p-4">
                            <h5 class="text-2xl font-semibold text-purple-700 mb-4">Additional Information</h5>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Citizenship:</p>
                                        <p class="font-medium">{{ $documentRequest->Citizenship ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Occupation:</p>
                                        <p class="font-medium">{{ $documentRequest->Occupation ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Gender:</p>
                                        <p class="font-medium">{{ $documentRequest->Gender ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Civil Status:</p>
                                        <p class="font-medium">{{ $documentRequest->CivilStatus ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Length of Stay:</p>
                                        <p class="font-medium">{{ $documentRequest->LengthOfStay ?? 'N/A' }} years</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Document Details --}}
                    <div class="border rounded-lg p-4">
                        <h5 class="text-2xl font-semibold text-purple-700 mb-4">Document Details</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Document Type:</p>
                                        <p class="font-medium">{{ $documentRequest->DocumentType }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Purpose:</p>
                                        <p class="font-medium">{{ $documentRequest->Purpose }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">TIN No:</p>
                                        <p class="font-medium">{{ $documentRequest->TIN_No ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">CTC No:</p>
                                        <p class="font-medium">{{ $documentRequest->CTC_No ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Quantity:</p>
                                        <p class="font-medium">{{ $documentRequest->Quantity ?? 1 }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Price:</p>
                                        <p class="font-medium">{{ $price }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Date Requested:</p>
                                        <p class="font-medium">{{ $documentRequest->DateRequested ? \Carbon\Carbon::parse($documentRequest->DateRequested)->format('F d, Y h:i A') : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="mb-1">
                                        <p class="text-gray-500 text-sm">Date Approved:</p>
                                        <p class="font-medium">{{ $documentRequest->date_approved ? \Carbon\Carbon::parse($documentRequest->date_approved)->format('F d, Y h:i A') : '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Valid ID Images --}}
                    <div class="border rounded-lg p-4">
                        <h5 class="text-2xl font-semibold text-purple-700 mb-4">Valid ID Images</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h6 class="text-xl font-medium text-gray-700 mb-2">Front Side</h6>
                                @if ($documentRequest->valid_id_front)
                                    <img src="{{ strpos($documentRequest->valid_id_front, 'cloudinary.com') !== false ? 
                                        $documentRequest->valid_id_front : 
                                        asset('storage/' . $documentRequest->valid_id_front) }}"
                                        class="w-full h-auto border rounded shadow-sm zoomable object-contain max-h-[300px]"
                                        alt="Valid ID Front" 
                                        onclick="openImageModal(this.src, 'Front Side of ID')">
                                @else
                                    <div class="text-center py-10 border rounded bg-gray-50 text-gray-500">
                                        No front ID image uploaded
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h6 class="text-xl font-medium text-gray-700 mb-2">Back Side</h6>
                                @if ($documentRequest->valid_id_back)
                                    <img src="{{ strpos($documentRequest->valid_id_back, 'cloudinary.com') !== false ? 
                                        $documentRequest->valid_id_back : 
                                        asset('storage/' . $documentRequest->valid_id_back) }}"
                                        class="w-full h-auto border rounded shadow-sm zoomable object-contain max-h-[300px]"
                                        alt="Valid ID Back" 
                                        onclick="openImageModal(this.src, 'Back Side of ID')">
                                @else
                                    <div class="text-center py-10 border rounded bg-gray-50 text-gray-500">
                                        No back ID image uploaded
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Document Status --}}
                    <div class="border rounded-lg p-4">
                        <h5 class="text-2xl font-semibold text-purple-700 mb-4">Document Status</h5>
                        <form method="POST" id="statusForm" action="{{ route('documents.update', $documentRequest->Id) }}">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="statusSelect" class="block text-xl font-medium text-gray-700 mb-2">Current Status</label>
                                    <select id="statusSelect" name="status"
                                        class="mt-1 block w-full py-3 px-4 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-lg"
                                        {{ strtolower($documentRequest->Status) == 'cancelled' ? 'disabled' : '' }}>
                                        <option value="pending" {{ strtolower($documentRequest->Status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ strtolower($documentRequest->Status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ strtolower($documentRequest->Status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="cancelled" {{ strtolower($documentRequest->Status) == 'cancelled' ? 'selected' : '' }} disabled>Cancelled</option>
                                        <option value="overdue" {{ strtolower($documentRequest->Status) == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                    </select>
                                    @if (strtolower($documentRequest->Status) == 'cancelled' && $documentRequest->cancellation_reason)
                                        <div class="mt-2 text-sm text-gray-600">
                                            <span class="font-bold">Cancellation Reason:</span>
                                            {{ $documentRequest->cancellation_reason }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label for="pickupStatus" class="block text-xl font-medium text-gray-700 mb-2">Pickup Status</label>
                                    <select id="pickupStatus" name="pickup_status"
                                        class="mt-1 block w-full py-3 px-4 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-lg"
                                        {{ strtolower($documentRequest->Status) != 'approved' ? 'disabled' : '' }}>
                                        <option value="pending" {{ $documentRequest->pickup_status == 'pending' ? 'selected' : '' }}>Pending Pickup</option>
                                        <option value="picked_up" {{ $documentRequest->pickup_status == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                                    </select>
                                </div>
                            </div>
                            <div id="reasonContainer" class="{{ strtolower($documentRequest->Status) == 'rejected' ? '' : 'hidden' }} mt-4">
                                <label for="reason" class="block text-lg font-medium text-gray-700 mb-2">Reason for Rejection</label>
                                <input type="text" id="reason" name="reason"
                                    class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-lg"
                                    placeholder="Enter reason for rejection"
                                    value="{{ old('reason', $documentRequest->rejection_reason) }}"
                                    {{ strtolower($documentRequest->Status) == 'cancelled' ? 'disabled' : '' }}>
                            </div>
                            <div class="mt-6 flex justify-end space-x-4">
                                <button type="button" id="saveBtn"
                                    class="px-6 py-3 bg-purple-600 text-white rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ strtolower($documentRequest->Status) == 'cancelled' ? 'disabled' : '' }}
                                    onclick="openConfirmationModal()">
                                    Save Changes
                                </button>
                                @if(strtolower($documentRequest->DocumentType) !== 'cedula')
                                <a href="{{ route('documents.print.barangay_clearance', $documentRequest->Id) }}"
                                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg shadow-sm hover:bg-green-700 transition duration-150 ease-in-out text-lg"
                                   target="_blank">
                                    <i class="fas fa-print mr-2"></i> Print
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div> {{-- End of main content padding --}}

        {{-- Image Modal --}}
        <div id="imageModal" class="custom-modal">
            <div id="imageModalContent" class="custom-modal-content transform transition-all scale-95 opacity-0">
                <div class="modal-header">
                    <h3 id="imageModalLabel" class="text-xl font-semibold">Document Preview</h3>
                    <span class="custom-modal-close" id="closeImageBtn">&times;</span>
                </div>
                <div class="p-4 flex items-center justify-center">
                    <img id="modalImage" src="" alt="Document Preview" class="max-h-[70vh] w-auto max-w-full object-contain">
                </div>
            </div>
        </div>

        {{-- Confirm Modal --}}
        <div id="confirmModal" class="custom-modal">
            <div id="confirmModalContent" class="custom-modal-content transform transition-all scale-95 opacity-0">
                <div class="modal-header">
                    <h3 class="text-xl font-semibold">Confirm Changes</h3>
                    <span class="custom-modal-close" id="closeConfirmBtn">&times;</span>
                </div>
                <div class="p-4 text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-purple-100 mb-6">
                        <span class="material-icons text-purple-600 text-3xl">save</span>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm Status Update</h3>
                    <p class="text-gray-600 mb-8">Are you sure you want to save these changes to the document status?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition"
                        id="cancelButton">
                        Cancel
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition"
                        id="confirmButton">
                        Yes, Save Changes
                    </button>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Initialize modals
                function openImageModal(src, title) {
                    $('#modalImage').attr('src', src);
                    $('#imageModalLabel').text(title);
                    $('#imageModal').fadeIn(300);
                    $('body').addClass('modal-open');
                    
                    // Add animation delay
                    setTimeout(() => {
                        $('#imageModalContent').removeClass('scale-95 opacity-0');
                        $('#imageModalContent').addClass('scale-100 opacity-100');
                    }, 10);
                }
                
                function openConfirmationModal() {
                    const statusSelect = document.getElementById('statusSelect');
                    const reasonInput = document.getElementById('reason');

                    if (statusSelect.value === 'rejected' && (!reasonInput.value || !reasonInput.value.trim())) {
                        alert('Please provide a reason for rejection.');
                        reasonInput.focus();
                        return;
                    }
                    
                    $('#confirmModal').fadeIn(300);
                    $('body').addClass('modal-open');
                    
                    // Add animation delay
                    setTimeout(() => {
                        $('#confirmModalContent').removeClass('scale-95 opacity-0');
                        $('#confirmModalContent').addClass('scale-100 opacity-100');
                    }, 10);
                }
                
                function closeModal(modalId) {
                    // Reverse the animation
                    $(`#${modalId}Content`).removeClass('scale-100 opacity-100');
                    $(`#${modalId}Content`).addClass('scale-95 opacity-0');
                    
                    // Delay the fade out
                    setTimeout(() => {
                        $(`#${modalId}`).fadeOut(200);
                        $('body').removeClass('modal-open');
                    }, 200);
                }
                
                // Handle image clicks for opening modal
                $('.zoomable').on('click', function() {
                    const src = $(this).attr('src');
                    const alt = $(this).attr('alt') || 'Image Preview';
                    openImageModal(src, alt);
                });
                
                // Save button click opens confirm modal
                $('#saveBtn').on('click', function() {
                    openConfirmationModal();
                });
                
                // Close buttons for image modal
                $('#closeImageBtn').on('click', function() {
                    closeModal('imageModal');
                });
                
                // Close buttons for confirm modal
                $('#closeConfirmBtn, #cancelButton').on('click', function() {
                    closeModal('confirmModal');
                });
                
                // Confirm button submits the form
                $('#confirmButton').on('click', function() {
                    submitForm();
                });
                
                // Close modals when clicking outside content
                $('.custom-modal').on('click', function(e) {
                    if (e.target === this) {
                        closeModal($(this).attr('id'));
                    }
                });
                
                // Handler for status select change
                $('#statusSelect').on('change', function() {
                    if (this.value === 'rejected') {
                        $('#reasonContainer').removeClass('hidden');
                        $('#reason').prop('required', true);
                    } else {
                        $('#reasonContainer').addClass('hidden');
                        $('#reason').prop('required', false);
                    }

                    if (this.value === 'approved') {
                        $('#pickupStatus').prop('disabled', false);
                    } else {
                        $('#pickupStatus').prop('disabled', true);
                        $('#pickupStatus').val('pending');
                    }
                });
            });

            function submitForm() {
                const form = document.getElementById('statusForm');
                const formData = new FormData(form);
                
                // Disable the submit button to prevent double submission
                $('#confirmButton').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');

                // Submit the form using jQuery AJAX
                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    success: function(data) {
                        if (data.success) {
                            // Show success message
                            alert('Status updated successfully!');
                            // Redirect back to document list
                            window.location.href = "{{ route('documents.index') }}";
                        } else {
                            alert(data.message || 'Failed to update status');
                            $('#confirmButton').prop('disabled', false).text('Confirm');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        
                        try {
                            // Try to parse the error response
                            const errorData = JSON.parse(xhr.responseText);
                            alert('Error updating status: ' + (errorData.message || error));
                        } catch(e) {
                            alert('Error updating status: ' + error);
                        }
                        
                        $('#confirmButton').prop('disabled', false).text('Confirm');
                    }
                });
            }
        </script>

    @endsection {{-- End of content section --}}

</body>

</html>