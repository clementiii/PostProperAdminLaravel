@extends('layouts.app')

@section('title', 'Archived Users')

@section('content')
<div class="container mx-auto px-4 py-8">
    <livewire:archived-user-table />
</div>
@endsection