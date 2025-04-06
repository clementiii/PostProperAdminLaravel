<div>
    <div class="relative z-10 {{ !$isOpen ? 'hidden' : '' }}" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div
            class="fixed inset-0 left-0 top-0 bg-black bg-opacity-50 w-screen h-screen flex justify-center items-center">
            <div class="bg-white rounded shadow-lg flex flex-col p-8 w-[40%] relative">
                <div class="flex flex-col w-full border-b pb-4">
                    <h2 class="text-2xl font-semibold">Request Details</h2>
                    <p class="text-gray-500">View complete information about this document request</p>
                    <div class="absolute top-[2.5rem] right-[2.5rem] flex items-center space-x-12">
                        <span
                            class="bg-yellow-100 text-yellow-800 text-sm font-semibold px-3 py-1 rounded-full">Pending</span>
                        <button wire:click="$set('isOpen', false)" class="material-icons-outlined">close</button>
                    </div>
                </div>

                @if($request)
                    <div class="mt-6 space-y-4">
                        <h3 class="text-purple-800 font-semibold">Document Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">tag</i>
                                <span class="font-semibold">Transaction ID:</span>
                                <span>TXN-{{ str_pad((string) $request->id, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">description</i>
                                <span class="font-semibold">Document Type:</span>
                                <span>{{ $request->DocumentType }}</span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">attach_money</i>
                                <span class="font-semibold">Price:</span>
                                <span>N/A</span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">event</i>
                                <span class="font-semibold">Date Requested:</span>
                                <span>{{ $request->created_at }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <h3 class="text-purple-800 font-semibold">Personal Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">person</i>
                                <span class="font-semibold">Full Name:</span>
                                <span>{{ $request->Name }}</span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">male</i>
                                <span class="font-semibold">Gender:</span>
                                <span>{{ $request->Gender }}</span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">favorite</i>
                                <span class="font-semibold">Civil Status:</span>
                                <span>{{ $request->CivilStatus }}</span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">location_on</i>
                                <span class="font-semibold">Address:</span>
                                <span>{{ $request->Address }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <h3 class="text-purple-800 font-semibold">Additional Information</h3>
                        <div class="grid grid-cols-2 gap-4 text-gray-700">
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">badge</i>
                                <span class="font-semibold">TIN No.:</span>
                                <span>{{ $request->TIN_No }}</span>
                            </div>
                            <div>
                                <i class="material-icons-outlined align-middle mr-2 text-gray-500">fingerprint</i>
                                <span class="font-semibold">CTC No.:</span>
                                <span>{{ $request->CTC_No }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-8 flex justify-end">
                    <button wire:click="$set('isOpen', false)"
                        class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Close
                    </button>
                </div>
                <div class="mt-4 flex justify-center">
                    <ul class="pagination text-xl space-x-3">
                        <li><button class="px-6 py-3 bg-gray-200 rounded hover:bg-gray-300">1</button></li>
                        <li><button class="px-6 py-3 bg-gray-200 rounded hover:bg-gray-300">2</button></li>
                        <li><button class="px-6 py-3 bg-gray-200 rounded hover:bg-gray-300">3</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>