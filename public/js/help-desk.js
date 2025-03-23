document.addEventListener("DOMContentLoaded", function () {
    const chatForm = document.getElementById("chat-form");
    const messageInput = document.getElementById("message-input");
    const chatMessages = document.getElementById("chat-messages");

    // Function to scroll to bottom of chat
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Initial scroll to bottom
    scrollToBottom();

    // Handle form submission
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

    // Function to fetch messages
    function fetchMessages() {
        fetch("/help-desk/get-messages")
            .then((response) => response.json())
            .then((messages) => {
                // Update chat messages
                chatMessages.innerHTML = messages
                    .map((message) => {
                        const isAdmin = message.is_admin;
                        const messageClass = isAdmin ? "mr-auto" : "ml-auto";
                        const bubbleClass = isAdmin
                            ? "bg-gray-100 text-gray-900"
                            : "bg-purple-800 text-white";
                        const time = new Date(
                            message.timestamp
                        ).toLocaleTimeString("en-US", {
                            hour: "numeric",
                            minute: "numeric",
                            hour12: true,
                        });

                        return `
                        <div class="message mb-4 ${messageClass} max-w-[70%]">
                            <div class="${bubbleClass} rounded-2xl px-4 py-2">
                                <div class="flex justify-between items-center mb-1 text-sm">
                                    <span class="font-medium">${
                                        isAdmin ? "Admin" : "You"
                                    }</span>
                                    <span class="text-xs opacity-75">${time}</span>
                                </div>
                                <div class="break-words">
                                    ${message.message}
                                </div>
                            </div>
                        </div>
                    `;
                    })
                    .join("");

                scrollToBottom();
            })
            .catch((error) => {
                console.error("Error:", error);
            });
    }

    // Fetch messages every 5 seconds
    setInterval(fetchMessages, 5000);
});
