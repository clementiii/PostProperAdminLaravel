@extends('layouts.app')

@section('title', 'User Accounts')

@section('content')
<div class="p-6">
    <!-- User Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-blue-500 text-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold">Registered Residents</h3>
            <p class="text-2xl font-bold">{{ $registeredResidentsCount }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold">Active Users</h3>
            <p class="text-2xl font-bold">{{ $activeUsersCount }}</p>
        </div>
        <div class="bg-gray-500 text-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold">Inactive Users</h3>
            <p class="text-2xl font-bold">{{ $inactiveUsersCount }}</p>
        </div>
    </div>

    <!-- User Table -->
    <div class="bg-white mt-6 p-6 rounded-xl shadow">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Last Name</th>
                    <th class="border p-2">First Name</th>
                    <th class="border p-2">Address</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border">
                    <td class="border p-2">{{ $user->lastName }}</td>
                    <td class="border p-2">{{ $user->firstName }}</td>
                    <td class="border p-2">
                        {{ $user->adrHouseNo }} {{ $user->adrStreet }} {{ $user->adrZone }}
                    </td>
                    <td class="border p-2">
                        @php
                            $statusClass = match(strtolower($user->status)) {
                                'verified' => 'bg-green-500',
                                'rejected' => 'bg-red-500',
                                default => 'bg-yellow-500'
                            };
                        @endphp
                        <span class="px-3 py-1 text-white rounded-full {{ $statusClass }}">
                            {{ ucfirst($user->status ?? 'Pending') }}
                        </span>
                    </td>
                    <td class="border p-2 flex space-x-2">
                        <a href="{{ route('users.view', $user->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">View</a>
                        <button onclick="confirmDelete({{ $user->id }})" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
function confirmDelete(userId) {
    if (confirm("Are you sure you want to delete this user?")) {
        window.location.href = "/users/delete/" + userId;
    }
}
</script>
@endsection
