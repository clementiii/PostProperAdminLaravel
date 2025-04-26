document.addEventListener("DOMContentLoaded", function () {
    const chatForm = document.getElementById("chat-form");
    const messageInput = document.getElementById("message-input");
    const chatMessages = document.getElementById("chat-messages");
    const recipientId = document.getElementById("recipient-id");
    const searchInput = document.getElementById("search-users");

    // Function to scroll to bottom of chat
    function scrollToBottom() {
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    // Initial scroll to bottom
    scrollToBottom();

    // Handle form submission if form exists
    if (chatForm && messageInput && recipientId) {
        chatForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const message = messageInput.value.trim();
            if (!message) return;

            // Send message to server
            fetch("/help-desk/send-message", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: JSON.stringify({
                    message: message,
                    recipient_id: recipientId.value,
                }),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === "success") {
                        // Clear input
                        messageInput.value = "";

                        // Refresh messages
                        fetchMessages();
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        });
    }

    // Function to fetch messages
    function fetchMessages() {
        if (!recipientId) return;

        fetch("/help-desk/get-messages", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                user_id: recipientId.value,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success" && chatMessages) {
                    // Update chat messages
                    let messagesHtml = "";

                    if (data.messages.length === 0) {
                        messagesHtml = `
                            <div class="text-center text-gray-500 py-6">
                                <p>No messages in this conversation yet</p>
                                <p class="text-sm">Send a message to start the conversation</p>
                            </div>
                        `;
                    } else {
                        data.messages.forEach((message) => {
                            const isAdmin = message.is_admin;
                            const time = new Date(
                                message.timestamp
                            ).toLocaleTimeString("en-US", {
                                hour: "numeric",
                                minute: "numeric",
                                hour12: true,
                            });

                            // Get user details for avatar
                            let avatar = "";
                            let senderName = isAdmin ? "Admin" : "User";

                            if (!isAdmin && message.sender) {
                                senderName = message.sender.firstName || "User";

                                // Check if user has profile picture
                                if (message.sender.user_profile_picture) {
                                    avatar = `<img src="${message.sender.user_profile_picture}" class="user-avatar w-8 h-8 rounded-full object-cover" alt="${senderName}" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(senderName)}&background=random';">`;
                                } else {
                                    // Create initials avatar
                                    let initials = "";
                                    if (message.sender.firstName) {
                                        initials +=
                                            message.sender.firstName.charAt(0);
                                    }
                                    if (message.sender.lastName) {
                                        initials +=
                                            message.sender.lastName.charAt(0);
                                    }
                                    initials = initials.toUpperCase() || "U";

                                    avatar = `<div class="user-avatar w-8 h-8 rounded-full bg-gray-300 text-gray-700 flex items-center justify-center text-sm font-medium">${initials}</div>`;
                                }
                            }

                            if (isAdmin) {
                                // Admin message
                                messagesHtml += `
                                    <div class="flex items-start justify-end space-x-2 mb-4">
                                        <div class="message-bubble admin-message bg-purple-800 text-white rounded-2xl px-4 py-2 max-w-[70%]">
                                            <p>${message.message}</p>
                                            <p class="text-xs text-gray-300 mt-1">${time}</p>
                                        </div>
                                        <div class="text-xs bg-gray-200 text-gray-700 rounded-full px-2 py-1">AD</div>
                                    </div>
                                `;
                            } else {
                                // User message
                                messagesHtml += `
                                    <div class="flex items-start space-x-2 mb-4">
                                        ${avatar}
                                        <div class="message-bubble user-message bg-gray-100 text-gray-900 rounded-2xl px-4 py-2 max-w-[70%]">
                                            <p>${message.message}</p>
                                            <p class="text-xs text-gray-500 mt-1">${time}</p>
                                        </div>
                                    </div>
                                `;
                            }
                        });
                    }

                    chatMessages.innerHTML = messagesHtml;
                    scrollToBottom();
                }
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const conversations =
                document.querySelectorAll(".conversation-item");

            conversations.forEach((item) => {
                const userName = item
                    .querySelector("h4")
                    .textContent.toLowerCase();
                const lastMessage = item
                    .querySelector("p")
                    .textContent.toLowerCase();

                if (
                    userName.includes(searchTerm) ||
                    lastMessage.includes(searchTerm)
                ) {
                    item.style.display = "flex";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    // Fetch messages every 5 seconds if we're in a conversation
    if (recipientId) {
        fetchMessages(); // Initial fetch
        setInterval(fetchMessages, 5000);
    }
});
