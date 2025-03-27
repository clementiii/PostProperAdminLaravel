@extends('layouts.app')

@section('title', 'Admin Staff')

@section('content')

    <div class="p-6 flex justify-evenly items-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($adminStaff as $staff)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 w-[35rem]">
                    <div class="bg-purple-900 text-white pb-[7rem] py-8 text-center relative">
                        <h3 class="text-3xl font-semibold">{{ $staff->name }}</h3>
                        <p class="text-lg">Administrator</p>
                        <div
                            class="absolute -bottom-12 left-1/2 transform -translate-x-1/2 w-32 h-32 rounded-full bg-purple-400 border-4 border-white">
                            <img src="{{ $staff->profile_picture }}" alt="{{ $staff->name }}"
                                class="w-full h-full rounded-full object-cover">
                        </div>
                    </div>
                    <div class="pt-16 pb-6 px-6">
                        <div class="flex justify-center gap-8">
                            @if (Auth::id() === $staff->id)
                                <a href="{{ route('admin.profile') }}"
                                    class="inline-flex items-center justify-center rounded-md text-base font-medium bg-blue-600 text-white px-5 py-2 hover:bg-blue-700">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                                <form action="{{ route('admin.delete', $staff->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')"
                                        class="inline-flex items-center justify-center rounded-md text-base font-medium bg-red-600 text-white px-5 py-2 hover:bg-red-700">
                                        <i class="fas fa-trash-alt mr-2"></i>Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-base text-gray-400"></span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection