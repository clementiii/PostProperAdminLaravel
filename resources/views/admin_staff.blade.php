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
                                <form action="{{ route('admin.delete', $staff->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')"
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
@endsection