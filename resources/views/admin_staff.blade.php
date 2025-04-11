@extends('layouts.app')

@section('title', 'Admin Staff')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($adminStaff as $staff)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
                    <div class="bg-purple-900 text-white pb-16 pt-6 text-center relative">
                        <h3 class="text-2xl font-semibold">{{ $staff->name }}</h3>
                        <p class="text-lg mt-1">Administrator</p>
                        <div class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 w-24 h-24 rounded-full bg-purple-400 border-4 border-white overflow-hidden">
                            <img src="{{ $staff->profile_picture }}" alt="{{ $staff->name }}"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="pt-16 pb-6 px-4">
                        <div class="flex justify-center gap-4">
                            @if (Auth::id() === $staff->id)
                                <a href="{{ route('admin.profile') }}"
                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-blue-600 text-white px-4 py-2 hover:bg-blue-700 transition-colors">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                                <form id="delete-form-{{ $staff->id }}" action="{{ route('admin.delete', $staff->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="openDeleteModal({{ $staff->id }})"
                                        class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-red-600 text-white px-4 py-2 hover:bg-red-700 transition-colors">
                                        <i class="fas fa-trash-alt mr-2"></i>Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 transform transition-all scale-95 opacity-0" id="modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <span class="material-icons text-red-600 text-3xl">delete</span>
                </div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Confirm Account Deletion</h3>
                <p class="text-gray-600 mb-8">Are you sure you want to delete your account? This action cannot be undone.</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" onclick="hideDeleteModal()" 
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="button" id="confirmDeleteBtn"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        Yes, Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Icons (for the delete icon) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Delete Modal Script -->
    <script>
        let currentDeleteId = null;

        function openDeleteModal(staffId) {
            currentDeleteId = staffId;
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('modal-content');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function hideDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = document.getElementById('modal-content');
            
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                currentDeleteId = null;
            }, 200);
        }
        
        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (currentDeleteId) {
                document.getElementById('delete-form-' + currentDeleteId).submit();
            }
        });

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });
    </script>
@endsection