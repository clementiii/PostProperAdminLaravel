@extends('layouts.dashboard-topbar')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 space-y-6">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 ">
        <div class="h-(95px) bg-blue-500 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-users text-4xl bg-white bg-opacity-20 p-3 rounded-lg"></i>
            <div class="ml-4">
                <h3 class="text-lg">Registered Residents</h3>
                <p id="residentsCount" class="text-2xl font-bold">{{ $registeredResidents }}</p>
            </div>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-file-alt text-4xl bg-white bg-opacity-20 p-3 rounded-lg"></i>
            <div class="ml-4">
                <h3 class="text-lg">Pending Documents</h3>
                <p id="pendingDocsCount" class="text-2xl font-bold">{{ $pendingDocuments }}</p>
            </div>
        </div>
        <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg flex items-center">
            <i class="fas fa-exclamation-circle text-4xl bg-white bg-opacity-20 p-3 rounded-lg"></i>
            <div class="ml-4">
                <h3 class="text-lg">Incident Reports</h3>
                <p id="incidentCount" class="text-2xl font-bold">{{ $incidentReports }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
