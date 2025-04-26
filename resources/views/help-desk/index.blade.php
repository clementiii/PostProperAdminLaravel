@extends('layouts.app') {{-- Make sure this matches your layout file name --}}
@section('title', 'Help Desk Chat')

@section('content')
{{-- Import Str for truncation --}}
@php use Illuminate\Support\Str; @endphp

<div class="container-fluid mx-auto p-4">
    {{-- Main chat container --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="height: calc(100vh - 8rem);">
        <div class="flex h-full">

            {{-- (User list HTML remains the same) --}}
            <div class="w-1/4 border-r border-gray-200 h-full flex flex-col">
                <div class="p-4 border-b"> <input type="text" id="user-search-input" placeholder="Search users..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-300"> </div>
                <div class="flex-1 overflow-y-auto" id="users-container">
                    @forelse($allUsers as $user)
                        <div id="user-item-{{ $user->id }}" class="user-chat-item p-3 border-b hover:bg-purple-100 cursor-pointer transition duration-150 ease-in-out" data-user-id="{{ $user->id }}" data-user-name="{{ e($user->firstName . ' ' . $user->lastName) }}">
                            <div class="flex items-center">
                                <img src="{{ $user->getProfilePictureUrl() ?: 'https://ui-avatars.com/api/?name='.urlencode($user->firstName.'+'.$user->lastName).'&background=random' }}" alt="{{ $user->firstName }}" class="w-10 h-10 rounded-full mr-3 object-cover flex-shrink-0" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ urlencode($user->firstName.'+'.$user->lastName) }}&background=random';">
                                <div class="flex-grow min-w-0">
                                    <div class="flex justify-between items-center"> <h4 class="font-medium text-sm truncate">{{ $user->firstName }} {{ $user->lastName }}</h4> @if($user->last_message_time_ts) <small class="text-xs text-gray-500 flex-shrink-0 ml-2"> {{ \Carbon\Carbon::parse($user->last_message_time_ts)->format('g:i A') }} </small> @endif </div>
                                    <p class="text-sm text-gray-600 truncate" title="{{ $user->latest_message_text ?? '' }}"> {{ Str::limit($user->latest_message_text ?? 'No messages', 35) }} </p>
                                </div>
                            </div>
                        </div>
                        <script>
                            (function() { const userItem = document.getElementById('user-item-{{ $user->id }}'); if (userItem) { userItem.addEventListener('click', function() { const userId = this.dataset.userId; const userName = this.dataset.userName; console.log(`Direct listener clicked! User ID: ${userId}, Name: ${userName}`); if (window.initiateChat && userId && userName) { console.log('Calling initiateChat from direct listener...'); window.initiateChat(userId, userName); } else { console.error('initiateChat function not found or user data missing.'); } }); } else { console.error('Could not find user item element #user-item-{{ $user->id }}'); } })();
                        </script>
                    @empty
                         <div class="p-4 text-center text-gray-500"> No active conversations. </div>
                    @endforelse
                </div>
            </div>

            {{-- (Chat area HTML structure remains the same) --}}
             <div class="flex-1 flex flex-col h-full bg-gray-50">
                  <div class="p-3 border-b flex items-center bg-white shadow-sm min-h-[65px]"> <div id="no-chat-selected" class="w-full text-center text-gray-500"> <p>Select a conversation</p> </div> <div id="chat-user-info" class="hidden w-full items-center"> <img id="chat-user-avatar" src="" alt="" class="w-10 h-10 rounded-full mr-3 object-cover" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=' + encodeURIComponent(document.getElementById('chat-user-name')?.textContent || 'User') + '&background=random';"> <div> <h3 id="chat-user-name" class="font-medium"></h3> </div> </div> </div>
                  <div class="flex-1 p-4 overflow-y-auto" id="messages-container" style="scroll-behavior: smooth;"></div>
                  <div class="border-t p-3 bg-white"> <form id="message-form" class="flex items-center"> @csrf <input type="hidden" id="recipient-id" name="user_id" value=""> <input type="text" id="message-input" placeholder="Type message..." disabled class="flex-1 border rounded-full py-2 px-4 mr-2 focus:outline-none focus:ring-2 focus:ring-purple-300 disabled:bg-gray-100"> <button type="submit" id="send-button" disabled class="bg-purple-700 hover:bg-purple-800 text-white rounded-full p-2 w-10 h-10 flex items-center justify-center focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 transform rotate-45 mb-px"> <path d="M3.105 3.105a.5.5 0 01.707-.707l14.142 14.142a.5.5 0 01-.707.707L3.105 3.812z" clip-rule="evenodd" /> <path d="M16.895 3.105a.5.5 0 01.707.707L3.812 17.596a.5.5 0 01-.707-.707l13.79-13.784z" clip-rule="evenodd" /> </svg> </button> </form> </div>
             </div>

        </div>
    </div>
</div> {{-- End of main content container --}}

{{-- Main script block --}}
<script>
    console.log('Help Desk Main Script START');

    // Shared state variables and functions defined in outer scope
    let messagePollingInterval = null;
    let currentChatUserId = null;
    let lastMessageTimestamp = 0;
    let displayedMessageIds = new Set();
    let currentUserAvatarUrl = 'https://ui-avatars.com/api/?name=U&background=random'; // Default fallback

    // Element references will be assigned within DOMContentLoaded
    let messagesContainer, noChatSelectedDiv, chatUserInfoDiv, chatUserNameEl, chatUserAvatarEl, recipientIdInput, messageInput, sendButton;

    // --- initiateChat Function (Remains the same) ---
    window.initiateChat = function(userId, userName) {
        console.log('initiateChat function started for:', userId, userName);
        messagesContainer = messagesContainer || document.getElementById('messages-container');
        noChatSelectedDiv = noChatSelectedDiv || document.getElementById('no-chat-selected');
        chatUserInfoDiv = chatUserInfoDiv || document.getElementById('chat-user-info');
        chatUserNameEl = chatUserNameEl || document.getElementById('chat-user-name');
        chatUserAvatarEl = chatUserAvatarEl || document.getElementById('chat-user-avatar');
        recipientIdInput = recipientIdInput || document.getElementById('recipient-id');
        messageInput = messageInput || document.getElementById('message-input');
        sendButton = sendButton || document.getElementById('send-button');

        currentChatUserId = userId; lastMessageTimestamp = 0; displayedMessageIds.clear();
        if (messagePollingInterval) { clearInterval(messagePollingInterval); messagePollingInterval = null; }
        noChatSelectedDiv.classList.add('hidden'); chatUserInfoDiv.classList.remove('hidden'); chatUserInfoDiv.classList.add('flex');
        chatUserNameEl.textContent = userName; recipientIdInput.value = userId; messageInput.disabled = false; sendButton.disabled = false;
        messagesContainer.innerHTML = '<div class="text-center py-4 text-gray-500"><p>Loading messages...</p></div>';
        fetch(`/help-desk/user-messages?user_id=${userId}`)
            .then(response => { if (!response.ok) { throw new Error(`HTTP error! status: ${response.status}`); } return response.json(); })
            .then(data => { 
                if (data.messages && data.user) {
                    currentUserAvatarUrl = data.user.user_profile_picture || `https://ui-avatars.com/api/?name=${encodeURIComponent(userName.replace(' ', '+'))}&background=random`;
                    chatUserAvatarEl.src = currentUserAvatarUrl;
                    // Always set onerror handler dynamically to ensure fallback works
                    chatUserAvatarEl.onerror = function() {
                        this.onerror = null;
                        this.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(userName.replace(' ', '+'))}&background=random`;
                    };
                    displayMessages(data.messages, false);
                    startPolling(userId);
                } else {
                    messagesContainer.innerHTML = '<div class="text-center py-4 text-gray-500"><p>Could not load messages.</p></div>'; console.error('Invalid data structure received:', data); 
                } 
            })
            .catch(error => { console.error('Error loading messages:', error); messagesContainer.innerHTML = `<div class="text-center py-4 text-red-500"><p>Error loading messages: ${error.message}</p></div>`; });
    }

    // --- displayMessages Function (Alignment Change) ---
    function displayMessages(messages, append = false) {
        messagesContainer = messagesContainer || document.getElementById('messages-container');
        if (!messagesContainer) { console.error("Messages container not found"); return; }

        if (!append) {
            displayedMessageIds.clear();
            if (!messagesContainer.querySelector('.text-center.py-4') || (messages && messages.length > 0)) { messagesContainer.innerHTML = ''; }
        }
        if (!messages || messages.length === 0) { if (!append && messagesContainer.innerHTML === '') { messagesContainer.innerHTML = '<div class="text-center py-4 text-gray-500"><p>No messages yet.</p></div>'; } return; }

        let newMessagesHtml = ''; let latestTimeInBatch = 0;

        messages.forEach(message => {
            const messageIdStr = message.id.toString();
             if (!append || !displayedMessageIds.has(messageIdStr)) {
                 displayedMessageIds.add(messageIdStr);

                 const isAdmin = message.is_admin;
                 let timeString = '';
                 try { const messageDate = new Date(message.timestamp); timeString = messageDate.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit', hour12: true }); const messageTime = messageDate.getTime(); if (messageTime > lastMessageTimestamp) { lastMessageTimestamp = messageTime; } if (messageTime > latestTimeInBatch) { latestTimeInBatch = messageTime; } } catch (e) { console.error("Error parsing timestamp:", message.timestamp, e); timeString = 'Invalid time'; }
                 const escapedMessage = document.createElement('div'); escapedMessage.textContent = message.message;

                 const messageBubbleHtml = `
                     <div class="${isAdmin ? 'bg-purple-700 text-white' : 'bg-gray-200 text-gray-900'} rounded-lg px-3 py-2 shadow-sm">
                         <div class="break-words text-sm">${escapedMessage.innerHTML}</div>
                         <div class="text-xs mt-1 text-right ${isAdmin ? 'text-purple-200' : 'text-gray-500'} opacity-75">${timeString}</div>
                     </div>
                 `;

                 if (isAdmin) {
                     // ** FIX: Changed items-end to items-start **
                     newMessagesHtml += `
                         <div class="flex items-start justify-end mb-3">
                             <div class="max-w-[75%] mr-2"> ${messageBubbleHtml} </div>
                             <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center text-xs font-semibold">AD</div>
                         </div>
                     `;
                 } else {
                     // ** FIX: Changed items-end to items-start **
                     newMessagesHtml += `
                         <div class="flex items-start mb-3">
                             <img src="${currentUserAvatarUrl}" alt="User" class="flex-shrink-0 w-8 h-8 rounded-full mr-2 object-cover" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=User&background=random';">
                             <div class="max-w-[75%]"> ${messageBubbleHtml} </div>
                         </div>
                     `;
                 }
             }
        });

        if (latestTimeInBatch > lastMessageTimestamp) { lastMessageTimestamp = latestTimeInBatch; }

        if (append) {
            const placeholder = messagesContainer.querySelector('.text-center.py-4');
            if (placeholder && newMessagesHtml.length > 0) { placeholder.remove(); }
            messagesContainer.insertAdjacentHTML('beforeend', newMessagesHtml);
        } else {
             if (messagesContainer.querySelector('.text-center.py-4')) { messagesContainer.innerHTML = ''; }
             messagesContainer.innerHTML = newMessagesHtml || '<div class="text-center py-4 text-gray-500"><p>No messages yet.</p></div>';
        }

        if (newMessagesHtml.length > 0) { messagesContainer.scrollTop = messagesContainer.scrollHeight; }
    }

    // --- fetchNewMessages Function (Remains the same) ---
    function fetchNewMessages(userId) {
         if (!userId || userId !== currentChatUserId) { if (messagePollingInterval) clearInterval(messagePollingInterval); return; } const timestampForQuery = lastMessageTimestamp > 0 ? lastMessageTimestamp + 1 : 0;
         fetch(`/help-desk/check-new-messages?user_id=${userId}&last_message_timestamp=${timestampForQuery}`)
             .then(response => { if (!response.ok) { if (response.status === 404) { console.warn('Polling endpoint not found.'); if (messagePollingInterval) clearInterval(messagePollingInterval); } else { console.error(`Polling error! status: ${response.status}`); } return null; } return response.json(); })
             .then(data => { if (data && data.hasNewMessages && data.newMessages.length > 0) { const messagesToAppend = data.newMessages.filter(msg => !displayedMessageIds.has(msg.id.toString())); if (messagesToAppend.length > 0) { console.log('Appending new unique messages:', messagesToAppend); displayMessages(messagesToAppend, true); } else { console.log('Polling received messages, but already displayed.'); const latestReceivedTimestamp = Math.max(...data.newMessages.map(msg => new Date(msg.timestamp).getTime())); if (latestReceivedTimestamp > lastMessageTimestamp) { console.log(`Updating lastMessageTimestamp from ${lastMessageTimestamp} to ${latestReceivedTimestamp}`); lastMessageTimestamp = latestReceivedTimestamp; } } } })
             .catch(error => { console.error('Error polling for new messages:', error); });
    }

    // --- startPolling Function (Remains the same) ---
    function startPolling(userId) {
         if (messagePollingInterval) { clearInterval(messagePollingInterval); } console.log(`Starting polling for user ${userId} every 5 seconds.`); fetchNewMessages(userId); messagePollingInterval = setInterval(() => fetchNewMessages(userId), 5000);
    }

    // --- Setup listeners that require DOM elements ---
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Help Desk Main Script: DOM Ready.');

        // Assign elements to variables
        messagesContainer = document.getElementById('messages-container');
        noChatSelectedDiv = document.getElementById('no-chat-selected');
        chatUserInfoDiv = document.getElementById('chat-user-info');
        chatUserNameEl = document.getElementById('chat-user-name');
        chatUserAvatarEl = document.getElementById('chat-user-avatar');
        recipientIdInput = document.getElementById('recipient-id');
        messageInput = document.getElementById('message-input');
        sendButton = document.getElementById('send-button');
        const messageForm = document.getElementById('message-form');
        const searchInput = document.getElementById('user-search-input');

        // Form Submission Listener (Remains the same)
        if (messageForm) {
             messageForm.addEventListener('submit', function(e) {
                 e.preventDefault(); const userId = recipientIdInput.value; const message = messageInput.value.trim(); if (!userId || !message) return; messageInput.disabled = true; sendButton.disabled = true;
                 fetch('/help-desk/send-message', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }, body: JSON.stringify({ user_id: userId, message: message }) })
                 .then(response => { if (!response.ok) { return response.json().then(errData => { throw new Error(`Server error: ${response.status} - ${errData.message || 'Unknown error'}`); }).catch(() => { throw new Error(`Server error: ${response.status}`); }); } return response.json(); })
                 .then(data => { if (data.status === 'success' && data.message) { messageInput.value = ''; fetchNewMessages(userId); console.log('Message sent successfully'); } else { console.error('Failed to send message:', data.message || 'Unknown backend issue'); alert(`Error: ${data.message || 'Could not send message.'}`); } })
                 .catch(error => { console.error('Error sending message:', error); alert(`Error sending message: ${error.message}`); })
                 .finally(() => { if (recipientIdInput.value) { messageInput.disabled = false; sendButton.disabled = false; messageInput.focus(); } });
             });
        } else { console.error("Message form not found!"); }

        // Basic User Search Listener (Remains the same)
        if (searchInput) {
             searchInput.addEventListener('input', function(e) { const searchTerm = e.target.value.toLowerCase().trim(); const userItems = document.querySelectorAll('#users-container .user-chat-item'); userItems.forEach(item => { const userNameElement = item.querySelector('h4'); const userName = userNameElement ? userNameElement.textContent.toLowerCase() : ''; if (userName.includes(searchTerm)) { item.style.display = ''; } else { item.style.display = 'none'; } }); });
        } else { console.warn("Search input not found."); }

        console.log('Help Desk Main Script: Event Listeners Attached.');

    }); // End DOMContentLoaded listener

    console.log('Help Desk Main Script END');
</script>

@endsection
