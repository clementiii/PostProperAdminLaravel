<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Verification</title>
    <link rel="icon" href="{{ asset('/assets/Southside.png') }}" type="image/png">
    {{-- Include Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4/dist/tailwind.min.css" rel="stylesheet">
    {{-- Include Font Awesome (if used for icons like the back button) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    {{-- Add any specific CSS for this page if needed --}}
    <style>
        /* Basic styling for info items if needed */
        .info-item strong {
            display: inline-block;
            width: 120px; /* Adjust as needed */
            font-weight: 600;
        }
        .info-item span {
            color: #555;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #4a5568; /* gray-700 */
            border-bottom: 1px solid #e2e8f0; /* gray-300 */
            padding-bottom: 0.5rem;
        }
        .zoomable { cursor: pointer; } /* Make images look clickable */
    </style>
</head>
<body class="bg-gray-100">

@extends('layouts.app')

@section('title', 'Document Verification')

@section('content')
<div class="p-6 space-y-6">

    <div class="document-header mb-4 flex justify-between items-center">
        {{-- Back button using JS history or link to index --}}
        <a href="{{ route('documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-150 ease-in-out text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
        <h2 class="text-2xl font-semibold text-purple-800 text-center flex-grow">Document Verification (TXN-{{ $documentRequest->Id }})</h2>
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

        <div class="p-6">
            <div class="mb-6 border border-gray-200 rounded-lg p-4">
                <h4 class="text-xl font-semibold mb-4 border-b pb-2 text-purple-700">Document Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="info-group space-y-2">
                            <h5 class="section-title">Personal Details</h5>
                            <div class="info-item"><strong>Name:</strong> <span>{{ $documentRequest->Name }}</span></div>
                            <div class="info-item"><strong>Address:</strong> <span>{{ $documentRequest->Address }}</span></div>
                            <div class="info-item"><strong>Age:</strong> <span>{{ $documentRequest->Age }} years old</span></div>
                            <div class="info-item"><strong>Birthday:</strong> <span>{{ $documentRequest->birthday ? \Carbon\Carbon::createFromFormat('m-d-y', $documentRequest->birthday)->format('F d, Y') : 'N/A' }}</span></div>
                            <div class="info-item"><strong>Place of Birth:</strong> <span>{{ $documentRequest->PlaceOfBirth ?? 'N/A' }}</span></div>
                            <div class="info-item"><strong>Alias:</strong> <span>{{ $documentRequest->Alias ?? 'N/A' }}</span></div>
                        </div>
                    </div>

                    <div>
                        <div class="info-group space-y-2 mb-6">
                            <h5 class="section-title">Additional Information</h5>
                            <div class="info-item"><strong>Citizenship:</strong> <span>{{ $documentRequest->Citizenship ?? 'N/A' }}</span></div>
                            <div class="info-item"><strong>Occupation:</strong> <span>{{ $documentRequest->Occupation ?? 'N/A' }}</span></div>
                            <div class="info-item"><strong>Gender:</strong> <span>{{ $documentRequest->Gender ?? 'N/A' }}</span></div>
                            <div class="info-item"><strong>Civil Status:</strong> <span>{{ $documentRequest->CivilStatus ?? 'N/A' }}</span></div>
                            <div class="info-item"><strong>Length of Stay:</strong> <span>{{ $documentRequest->LengthOfStay ?? 'N/A' }} years</span></div>
                        </div>

                        <div class="info-group space-y-2">
                             <h5 class="section-title">Document Details</h5>
                            <div class="info-item"><strong>Document Type:</strong> <span>{{ $documentRequest->DocumentType }}</span></div>
                            <div class="info-item"><strong>Purpose:</strong> <span>{{ $documentRequest->Purpose }}</span></div>
                            <div class="info-item"><strong>TIN No:</strong> <span>{{ $documentRequest->TIN_No ?? 'N/A' }}</span></div>
                            <div class="info-item"><strong>CTC No:</strong> <span>{{ $documentRequest->CTC_No ?? 'N/A' }}</span></div>
                            <div class="info-item"><strong>Quantity:</strong> <span>{{ $documentRequest->Quantity ?? 1 }}</span></div>
                            <div class="info-item"><strong>Price:</strong> <span>{{ $price }}</span></div> {{-- Use calculated price --}}
                            <div class="info-item"><strong>Date Requested:</strong> <span>{{ $documentRequest->DateRequested ? \Carbon\Carbon::parse($documentRequest->DateRequested)->format('F d, Y h:i A') : 'N/A' }}</span></div>
                            <div class="info-item"><strong>Date Approved:</strong> <span>{{ $documentRequest->date_approved ? \Carbon\Carbon::parse($documentRequest->date_approved)->format('F d, Y h:i A') : '-' }}</span></div>
                         </div>
                    </div>
                </div>

                <div class="status-section mt-6 pt-4 border-t">
                    <h5 class="section-title mb-4">Status Update</h5>
                    {{-- Use the documents.update route --}}
                    <form method="POST" action="{{ route('documents.update', $documentRequest->Id) }}" id="statusForm">
                        @csrf {{-- Add CSRF token --}}
                        @method('PUT') {{-- Specify PUT method --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                            <div>
                                <label for="statusSelect" class="block text-sm font-medium text-gray-700 mb-1">Current Status</label>
                                <select id="statusSelect" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" {{ strtolower($documentRequest->Status) == 'cancelled' ? 'disabled' : '' }}>
                                    {{-- Pre-select the current status --}}
                                    <option value="Pending" {{ $documentRequest->Status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ $documentRequest->Status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ $documentRequest->Status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    {{-- Show Cancelled but maybe don't allow selection *from* here? --}}
                                     <option value="Cancelled" {{ $documentRequest->Status == 'Cancelled' ? 'selected' : '' }} disabled>Cancelled</option>
                                </select>
                                 @if (strtolower($documentRequest->Status) == 'cancelled' && $documentRequest->cancellation_reason)
                                     <div class="mt-2 text-sm text-gray-600">
                                         <strong>Cancellation Reason:</strong> {{ $documentRequest->cancellation_reason }}
                                     </div>
                                 @endif
                            </div>

                            {{-- Reason for Rejection --}}
                            <div id="reasonContainer" class="{{ $documentRequest->Status == 'Rejected' ? '' : 'hidden' }}">
                                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection</label>
                                <input type="text" id="reason" name="reason" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="Enter reason if rejecting"
                                       value="{{ old('reason', $documentRequest->rejection_reason) }}" {{ strtolower($documentRequest->Status) == 'cancelled' ? 'disabled' : '' }}>
                            </div>
                        </div>

                         {{-- Save Button --}}
                        <div class="text-center mt-8">
                            {{-- Only enable save if not cancelled --}}
                            @if (strtolower($documentRequest->Status) != 'cancelled')
                            <button type="button" id="saveBtn" data-bs-toggle="modal" data-bs-target="#confirmModal" class="inline-flex items-center px-6 py-2 bg-purple-600 text-white rounded-md shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition duration-150 ease-in-out">
                                Save Changes
                            </button>
                            @else
                             <button type="button" class="inline-flex items-center px-6 py-2 bg-gray-400 text-white rounded-md shadow-sm cursor-not-allowed" disabled>
                                Save Changes (Request Cancelled)
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="mb-6 border border-gray-200 rounded-lg p-4">
                <h4 class="text-xl font-semibold mb-4 border-b pb-2 text-purple-700">Valid ID Images</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h5 class="mb-2 font-medium text-gray-700">Front Side</h5>
                        @if ($documentRequest->valid_id_front)
                            {{-- Ensure the path is correct, use asset() if stored publicly --}}
                            <img src="{{ asset('storage/' . $documentRequest->valid_id_front) }}" {{-- Assuming IDs are in storage/app/public and symlinked --}}
                                 class="w-full h-auto border rounded shadow-sm zoomable object-contain max-h-[300px]"
                                 alt="Valid ID Front"
                                 data-bs-toggle="modal"
                                 data-bs-target="#imageModal">
                        @else
                            <div class="text-center py-10 border rounded bg-gray-50 text-gray-500">No front ID image uploaded</div>
                        @endif
                    </div>

                    <div>
                        <h5 class="mb-2 font-medium text-gray-700">Back Side</h5>
                         @if ($documentRequest->valid_id_back)
                            <img src="{{ asset('storage/' . $documentRequest->valid_id_back) }}" {{-- Assuming IDs are in storage/app/public and symlinked --}}
                                 class="w-full h-auto border rounded shadow-sm zoomable object-contain max-h-[300px]"
                                 alt="Valid ID Back"
                                 data-bs-toggle="modal"
                                 data-bs-target="#imageModal">
                        @else
                            <div class="text-center py-10 border rounded bg-gray-50 text-gray-500">No back ID image uploaded</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> {{-- End of main content padding --}}


<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Document Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" class="img-fluid" alt="Document Preview" style="max-height: 80vh; width: 100%; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Save</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to save the changes to the document status?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                {{-- This button triggers the form submission --}}
                <button type="button" class="btn btn-primary" id="confirmSaveBtn">Confirm</button>
            </div>
        </div>
    </div>
</div>


{{-- Include jQuery and Bootstrap JS if not already in layout --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('statusSelect');
        const reasonContainer = document.getElementById('reasonContainer');
        const reasonInput = document.getElementById('reason');
        const saveButton = document.getElementById('saveBtn'); // Button that opens the confirm modal
        const confirmSaveButton = document.getElementById('confirmSaveBtn'); // Button inside the confirm modal
        const statusForm = document.getElementById('statusForm');
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal')); // Initialize Bootstrap modal JS instance
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));// Initialize Bootstrap modal JS instance

        // --- Status Change Handler ---
        if (statusSelect) {
            statusSelect.addEventListener('change', function() {
                if (this.value === 'Rejected') {
                    reasonContainer.classList.remove('hidden');
                } else {
                    reasonContainer.classList.add('hidden');
                    // Optionally clear the reason input when switching away from Rejected
                    // if(reasonInput) {
                    //    reasonInput.value = '';
                    // }
                }
            });
        }

         // --- Image Modal Handler ---
        document.querySelectorAll('.zoomable').forEach(image => {
            image.addEventListener('click', function() {
                const modalImage = document.getElementById('modalImage');
                const modalTitle = document.getElementById('imageModalLabel'); // Get title element by ID

                if (modalImage && modalTitle) {
                    modalImage.src = this.src;
                    // Update modal title based on the image's alt text
                    modalTitle.textContent = this.alt === 'Valid ID Front' ? 'Front Side of ID' : (this.alt === 'Valid ID Back' ? 'Back Side of ID' : 'Image Preview');
                    imageModal.show(); // Use Bootstrap JS instance to show
                }
            });
        });


        // --- Save Confirmation Handler ---
        if (confirmSaveButton && statusForm) {
             confirmSaveButton.addEventListener('click', function() {
                // Check if reason is required and empty
                if (statusSelect.value === 'Rejected' && (!reasonInput || !reasonInput.value.trim())) {
                    alert('Please provide a reason for rejection.');
                    // Optionally, keep the modal open or close it and focus the reason input
                    // confirmModal.hide(); // Hide confirmation modal
                     // reasonInput.focus(); // Focus the input
                    return; // Stop the form submission
                }
                // If validation passes, submit the form
                statusForm.submit();
             });
        }

        // Trigger confirmation modal when main save button is clicked
        // Note: Bootstrap's data-bs-toggle and data-bs-target handle opening the modal.
        // This script focuses on handling the *confirmation* within the modal.

         // Optional: Clean up Bootstrap backdrops if they persist after modal closure (sometimes happens)
        document.getElementById('confirmModal')?.addEventListener('hidden.bs.modal', function () {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
             // Ensure body scroll is restored if Bootstrap fails to do so
            document.body.style.overflow = 'auto';
            document.body.style.paddingRight = '0px';
        });
         document.getElementById('imageModal')?.addEventListener('hidden.bs.modal', function () {
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            document.body.style.overflow = 'auto';
            document.body.style.paddingRight = '0px';
        });

    });
</script>

@endsection {{-- End of content section --}}

</body>
</html>