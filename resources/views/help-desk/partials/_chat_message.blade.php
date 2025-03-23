<div class="message mb-4 {{ $message->is_admin ? 'mr-auto' : 'ml-auto' }} max-w-[70%]">
    <div
        class="{{ $message->is_admin ? 'bg-gray-100 text-gray-900' : 'bg-purple-800 text-white' }} rounded-2xl px-4 py-2">
        <div class="flex justify-between items-center mb-1 text-sm">
            <span class="font-medium">
                {{ $message->is_admin ? ($message->admin->name ?? 'Admin') : ($message->sender->firstName ?? 'You') }}
            </span>
            <span class="text-xs opacity-75">
                {{ \Carbon\Carbon::parse($message->timestamp)->format('h:i A') }}
            </span>
        </div>
        <div class="break-words">
            {{ $message->message }}
        </div>
    </div>
</div>