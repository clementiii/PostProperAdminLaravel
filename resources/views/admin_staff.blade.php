@extends('layouts.app')

@section('title', 'Admin Staff')

@section('content')

<div class="p-6">
    <!-- Admin Staff Table Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Staff Member</th>
                        <th class="text-right px-6 py-4 text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($adminStaff as $staff)
                    <tr class="group hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img 
                                    src="{{ $staff->profile_picture }}" 
                                    alt="{{ $staff->name }}"
                                    class="w-10 h-10 rounded-full object-cover border border-gray-200"
                                >
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900">{{ $staff->name }}</h3>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                @if (Auth::id() === $staff->id)
                                    <a href="{{ route('admin.profile') }}" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-white text-gray-900 shadow-sm hover:bg-purple-900 h-9 px-4 py-2 border border-gray-200">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.delete', $staff->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')" 
                                                class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-950 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-red-500 text-white shadow-sm hover:bg-red-600 h-9 px-4 py-2">
                                            Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="text-sm text-gray-400"></span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection