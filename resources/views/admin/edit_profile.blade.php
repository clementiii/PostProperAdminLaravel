@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Edit Profile</h2>

        <form method="POST" action="{{ route('admin.profile.update') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                       class="w-full p-2 border rounded">
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Update Profile
            </button>
        </form>
    </div>
</div>
@endsection
