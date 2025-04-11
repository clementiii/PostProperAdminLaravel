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

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 50;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }
        
        .modal.show {
            display: flex;
        }

        body.modal-open {
            overflow: hidden;
        }

        /* Make images look clickable */
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
                {{-- Placeholder for potential actions on the right --}}
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
                            <div class="space-y-2"> <!-- Added line height spacing -->
                                <div class="info-item"><span class="font-bold text-xl">Name:</span> <span
                                        class="text-xl">{{ $documentRequest->Name }}</span></div>
                                <div class="info-item"><span class="font-bold text-xl">Address:</span> <span
                                        class="text-xl">{{ $documentRequest->Address ?? 'N/A' }}</span></div>
                                <div class="info-item"><span class="font-bold text-xl">Age:</span> <span
                                        class="text-xl">{{ $documentRequest->Age }} years old</span></div>
                                <div class="info-item"><span class="font-bold text-xl">Date of Birth:</span>
                                    <span
                                        class="text-xl">{{ $documentRequest->birthday ? \Carbon\Carbon::createFromFormat('m-d-y', $documentRequest->birthday)->format('F d, Y') : 'N/A' }}</span>
                                </div>
                                <div class="info-item"><span class="font-bold text-xl">Place of Birth:</span> <span
                                        class="text-xl">{{ $documentRequest->PlaceOfBirth ?? 'N/A' }}</span></div>
                                <div class="info-item"><span class="font-bold text-xl">Alias:</span> <span
                                        class="text-xl">{{ $documentRequest->Alias ?? 'N/A' }}</span></div>
                            </div>
                        </div>
                        <div class="border rounded-lg p-4">
                            <h5 class="text-2xl font-semibold text-purple-700 mb-4">Additional Information</h5>
                            <div class="space-y-2"> <!-- Added line height spacing -->
                                <div class="info-item"><span class="font-bold text-xl">Citizenship:</span> <span
                                        class="text-xl">{{ $documentRequest->Citizenship ?? 'N/A' }}</span></div>
                                <div class="info-item"><span class="font-bold text-xl">Occupation:</span> <span
                                        class="text-xl">{{ $documentRequest->Occupation ?? 'N/A' }}</span></div>
                                <div class="info-item"><span class="font-bold text-xl">Gender:</span> <span
                                        class="text-xl">{{ $documentRequest->Gender ?? 'N/A' }}</span></div>
                                <div class="info-item"><span class="font-bold text-xl">Civil Status:</span> <span
                                        class="text-xl">{{ $documentRequest->CivilStatus ?? 'N/A' }}</span></div>
                                <div class="info-item"><span class="font-bold text-xl">Length of Stay:</span> <span
                                        class="text-xl">{{ $documentRequest->LengthOfStay ?? 'N/A' }} years</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- Document Details --}}
                    <div class="border rounded-lg p-4">
                        <h5 class="text-2xl font-semibold text-purple-700 mb-4">Document Details</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="info-item"><span class="font-bold text-xl">Document Type:</span> <span
                                    class="text-xl">{{ $documentRequest->DocumentType }}</span></div>
                            <div class="info-item"><span class="font-bold text-xl">Purpose:</span> <span
                                    class="text-xl">{{ $documentRequest->Purpose }}</span></div>
                            <div class="info-item"><span class="font-bold text-xl">TIN No:</span> <span
                                    class="text-xl">{{ $documentRequest->TIN_No ?? 'N/A' }}</span></div>
                            <div class="info-item"><span class="font-bold text-xl">CTC No:</span> <span
                                    class="text-xl">{{ $documentRequest->CTC_No ?? 'N/A' }}</span></div>
                            <div class="info-item"><span class="font-bold text-xl">Quantity:</span> <span
                                    class="text-xl">{{ $documentRequest->Quantity ?? 1 }}</span></div>
                            <div class="info-item"><span class="font-bold text-xl">Price:</span> <span
                                    class="text-xl">{{ $price }}</span></div>
                            <div class="info-item"><span class="font-bold text-xl">Date Requested:</span>
                                <span
                                    class="text-xl">{{ $documentRequest->DateRequested ? \Carbon\Carbon::parse($documentRequest->DateRequested)->format('F d, Y h:i A') : 'N/A' }}</span>
                            </div>
                            <div class="info-item"><span class="font-bold text-xl">Date Approved:</span>
                                <span
                                    class="text-xl">{{ $documentRequest->date_approved ? \Carbon\Carbon::parse($documentRequest->date_approved)->format('F d, Y h:i A') : '-' }}</span>
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
                                        onclick="openModal(this.src, 'Front Side of ID')">
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
                                        onclick="openModal(this.src, 'Back Side of ID')">
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
                            <div class="mt-6 flex justify-end">
                                <button type="button" id="saveBtn"
                                    class="px-6 py-3 bg-purple-600 text-white rounded-lg shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                    {{ strtolower($documentRequest->Status) == 'cancelled' ? 'disabled' : '' }}
                                    onclick="openConfirmModal()">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div> {{-- End of main content padding --}}

        {{-- Image Modal --}}
        <div id="imageModal" class="modal">
            <div class="relative bg-white rounded-lg max-w-6xl w-full mx-4">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900" id="imageModalLabel">Document Preview</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" id="closeImageModalBtn">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 flex items-center justify-center">
                    <img id="modalImage" src="" alt="Document Preview" class="max-h-[80vh] w-auto max-w-full object-contain">
                </div>
            </div>
        </div>

        {{-- Confirm Modal --}}
        <div id="confirmModal" class="modal">
            <div class="relative bg-white rounded-lg max-w-md w-full mx-4">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">Confirm Changes</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" id="closeConfirmModalBtn">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">Are you sure you want to save the changes to the document status?</p>
                </div>
                <div class="px-4 py-3 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
                    <button type="button" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        id="cancelConfirmBtn">
                        Cancel
                    </button>
                    <button type="button"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
                        onclick="submitForm()">
                        Confirm
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openModal(src, title) {
                document.getElementById('modalImage').src = src;
                document.getElementById('imageModalLabel').textContent = title;
                document.getElementById('imageModal').classList.add('show');
                document.body.classList.add('modal-open');
            }

            function openConfirmModal() {
                const statusSelect = document.getElementById('statusSelect');
                const reasonInput = document.getElementById('reason');

                if (statusSelect.value === 'rejected' && (!reasonInput.value || !reasonInput.value.trim())) {
                    alert('Please provide a reason for rejection.');
                    reasonInput.focus();
                    return;
                }

                document.getElementById('confirmModal').classList.add('show');
                document.body.classList.add('modal-open');
            }

            function closeModal(modalId) {
                console.log(`Closing modal: ${modalId}`);
                const modal = document.getElementById(modalId);
                if (modal) {
                    modal.classList.remove('show');
                    document.body.classList.remove('modal-open');
                } else {
                    console.error(`Modal element not found: ${modalId}`);
                }
            }

            function submitForm() {
                const form = document.getElementById('statusForm');
                const formData = new FormData(form);
                
                // Disable the submit button to prevent double submission
                const submitButton = document.querySelector('button[type="button"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

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
                            submitButton.disabled = false;
                            submitButton.innerHTML = 'Save Changes';
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
                        
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Save Changes';
                    }
                });
            }

            // Initialize modal close handlers
            document.addEventListener('DOMContentLoaded', function() {
                // Setup direct event handlers for buttons with IDs
                const closeImageModalBtn = document.getElementById('closeImageModalBtn');
                const closeConfirmModalBtn = document.getElementById('closeConfirmModalBtn');
                const cancelConfirmBtn = document.getElementById('cancelConfirmBtn');
                
                if (closeImageModalBtn) {
                    closeImageModalBtn.addEventListener('click', function() {
                        closeModal('imageModal');
                    });
                }
                
                if (closeConfirmModalBtn) {
                    closeConfirmModalBtn.addEventListener('click', function() {
                        closeModal('confirmModal');
                    });
                }
                
                if (cancelConfirmBtn) {
                    cancelConfirmBtn.addEventListener('click', function() {
                        closeModal('confirmModal');
                    });
                }
                
                // Close modal when clicking outside
                const modals = document.querySelectorAll('.modal');
                modals.forEach(function(modal) {
                    modal.addEventListener('click', function(event) {
                        if (event.target === modal) {
                            closeModal(modal.id);
                        }
                    });
                });
                
                // Other existing event listeners
                const statusSelect = document.getElementById('statusSelect');
                const pickupStatus = document.getElementById('pickupStatus');
                const reasonContainer = document.getElementById('reasonContainer');
                const reasonInput = document.getElementById('reason');

                if (statusSelect) {
                    statusSelect.addEventListener('change', function() {
                        if (this.value === 'rejected') {
                            reasonContainer.classList.remove('hidden');
                            reasonInput.required = true;
                        } else {
                            reasonContainer.classList.add('hidden');
                            reasonInput.required = false;
                        }

                        if (this.value === 'approved') {
                            pickupStatus.disabled = false;
                        } else {
                            pickupStatus.disabled = true;
                            pickupStatus.value = 'pending';
                        }
                    });
                }
            });
            
            // Make jQuery-based button selectors work
            if (typeof jQuery !== 'undefined') {
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            }
        </script>

    @endsection {{-- End of content section --}}

</body>

</html>