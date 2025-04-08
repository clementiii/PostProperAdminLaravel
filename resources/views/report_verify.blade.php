@extends('layouts.app')

@section('title', 'Report Verification')

@section('content')
<div class="p-6 space-y-6" x-data>
    {{-- Status Alert Messages --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Header with Back Button --}}
    <div class="document-header mb-6 flex justify-between items-center">
        <a href="{{ route('incident-reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-150 ease-in-out text-sm">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
        <h2 class="text-2xl font-semibold text-purple-800 text-center flex-grow">Report Verification (ID: {{ $incidentReport->id }})</h2>
        <div class="w-[80px]"></div> {{-- Spacer --}}
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="h-1 bg-purple-800"></div> {{-- Top Border --}}
        
        {{-- Status Badge --}}
        <div class="px-6 pt-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $incidentReport->isResolved() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                <span class="h-2 w-2 mr-1 rounded-full {{ $incidentReport->isResolved() ? 'bg-green-500' : 'bg-yellow-500' }}"></span>
                {{ $incidentReport->isResolved() ? 'Resolved' : 'Pending' }}
            </span>
            
            @if($incidentReport->isResolved() && $incidentReport->resolved_at)
                <span class="text-sm text-gray-500 ml-2">
                    Resolved on {{ $incidentReport->formatted_resolved_at }}
                </span>
            @endif
        </div>
        
        <div class="p-6 space-y-4">
            {{-- Title --}}
            <div>
                <label for="reportTitle" class="block text-sm font-medium text-gray-700">Title:</label>
                <input type="text" id="reportTitle" value="{{ $incidentReport->title }}" readonly
                       class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            {{-- Description --}}
            <div>
                <label for="reportDescription" class="block text-sm font-medium text-gray-700">Description:</label>
                <textarea id="reportDescription" readonly rows="6"
                          class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-50 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >{{ $incidentReport->description }}</textarea>
            </div>

            {{-- Images --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Images:</label>
                <div class="flex overflow-x-auto space-x-4 p-2 bg-gray-50 border rounded-md">
                    @if (count($incidentReport->formattedPictures) > 0)
                        @foreach ($incidentReport->formattedPictures as $imagePath)
                            <img src="{{ asset('storage/' . $imagePath) }}"
                                 alt="Incident Image"
                                 class="h-40 w-40 object-cover rounded-md border shadow-sm cursor-pointer hover:opacity-80 transition-opacity"
                                 @click="$dispatch('open-image-modal', { src: '{{ asset('storage/' . $imagePath) }}', title: 'Incident Image Preview' })">
                        @endforeach
                    @else
                        <p class="text-gray-500 italic">No images uploaded for this report.</p>
                    @endif
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4 border-t mt-4">
                @if (!$incidentReport->isResolved())
                    <form action="{{ route('incident-reports.resolve', $incidentReport) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                            <i class="fas fa-check-circle mr-2"></i> Mark as Resolved
                        </button>
                    </form>
                @else
                    <div class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-600 rounded-md cursor-not-allowed">
                        <i class="fas fa-check-circle mr-2"></i> Already Resolved
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Image Modal --}}
    <div x-data="{ open: false, imgSrc: '', imgTitle: '' }" x-cloak
         @open-image-modal.window="imgSrc = $event.detail.src; imgTitle = $event.detail.title; open = true"
         @keydown.escape.window="open = false"
         x-show="open"
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="image-modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity"></div>
        {{-- Modal Content --}}
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div x-show="open" @click.away="open = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-4xl w-full">
                {{-- Header --}}
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between items-center border-b">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="image-modal-title" x-text="imgTitle">Image Preview</h3>
                    <button @click="open = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"> 
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                {{-- Body --}}
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 text-center"> 
                    <img :src="imgSrc" class="max-w-full max-h-[75vh] mx-auto" alt="Image Preview"> 
                </div>
                {{-- Footer --}}
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t"> 
                    <button @click="open = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"> 
                        Close 
                    </button> 
                </div>
            </div>
        </div>
    </div>
    {{-- End Image Modal --}}

</div> {{-- End Main Content x-data --}}
@endsection

@push('scripts')
<script>
    // Additional scripts can be added here if needed
</script>
@endpush