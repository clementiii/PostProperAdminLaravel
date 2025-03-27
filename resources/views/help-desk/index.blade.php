<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Help Desk Chat - Post Proper Southside</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        .chat-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            height: calc(100vh - 4rem);
            /* Increased height */
            width: calc(100vw - 2rem);
            /* Increased width */
            margin: auto;
            /* Center the container */
        }

        .conversation-list {
            border-right: 1px solid #e5e7eb;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .conversation-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
        }

        .conversation-item:hover {
            background-color: #f9fafb;
        }

        .message-bubble {
            max-width: 80%;
            padding: 10px 15px;
            border-radius: 15px;
            margin: 5px 0;
        }

        .admin-message {
            background-color: #6b21a8;
            color: white;
            margin-left: auto;
        }

        .user-message {
            background-color: #f3f4f6;
            color: #374151;
        }
    </style>
</head>

<body>
    @extends('layouts.app')
    @section('title', 'Help Desk Chat')

    @section('content')
        <div class="fluid-container mx-auto p-4 h-full w-full">
            <div class="chat-container flex h-full w-full">
                <!-- Left Sidebar - Conversation List -->
                <div class="conversation-list w-1/4 bg-white rounded-l-lg h-full">
                    <!-- Search Bar -->
                    <div class="p-4 border-b">
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <i class="fas fa-search text-gray-400"></i>
                            </span>
                            <input type="text" placeholder="Search conversations..."
                                class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:border-purple-500">
                        </div>
                    </div>

                    <!-- Conversations -->
                    <div class="overflow-y-auto">
                        <!-- Sample Conversations -->
                        <div class="conversation-item flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=Pedro+Martinez" class="user-avatar" alt="Pedro">
                            <div class="flex-1">
                                <h4 class="font-medium">Pedro Martinez</h4>
                                <p class="text-sm text-gray-500 truncate">Hello! I need assistance regarding my...</p>
                            </div>
                        </div>

                        <div class="conversation-item flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=Juan+Dela+Cruz" class="user-avatar" alt="Juan">
                            <div class="flex-1">
                                <h4 class="font-medium">Juan Dela Cruz</h4>
                                <p class="text-sm text-gray-500 truncate">Good afternoon! How can I renew my b...</p>
                            </div>
                        </div>

                        <div class="conversation-item flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=Katrina+Mendoza" class="user-avatar" alt="Katrina">
                            <div class="flex-1">
                                <h4 class="font-medium">Katrina Mendoza</h4>
                                <p class="text-sm text-gray-500 truncate">I lost my barangay clearance. Can I...</p>
                            </div>
                        </div>

                        <div class="conversation-item flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=George+Peterson" class="user-avatar" alt="George">
                            <div class="flex-1">
                                <h4 class="font-medium">George Peterson</h4>
                                <p class="text-sm text-gray-500 truncate">Hello, I would like to request a barangay...</p>
                            </div>
                        </div>

                        <div class="conversation-item flex items-center space-x-3">
                            <img src="https://ui-avatars.com/api/?name=Maria+Santos" class="user-avatar" alt="Maria">
                            <div class="flex-1">
                                <h4 class="font-medium">Maria Santos</h4>
                                <p class="text-sm text-gray-500 truncate">Hello, I would like to request a barangay...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Chat Area -->
                <div class="flex-1 flex flex-col h-full">
                    <!-- Chat Header -->
                    <div class="p-4 border-b flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name=Maria+Santos" class="user-avatar" alt="Maria">
                        <div>
                            <h3 class="font-medium">Maria Santos</h3>
                            <p class="text-sm text-green-500">Online</p>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-4">
                        <!-- User Message -->
                        <div class="flex items-start space-x-2">
                            <img src="https://ui-avatars.com/api/?name=Maria+Santos" class="user-avatar w-8 h-8"
                                alt="Maria">
                            <div class="message-bubble user-message">
                                <p>Hello, gusto ko sana ng konting tulong ng barangay ID. Ano po ang mga kailangan
                                    requirements?</p>
                                <p class="text-xs text-gray-500 mt-1">11:15 AM</p>
                            </div>
                        </div>

                        <!-- Admin Message -->
                        <div class="flex items-start justify-end space-x-2">
                            <div class="message-bubble admin-message">
                                <p>Magandang umaga, Maria! Ang pagkuha ng barangay ID ay ginagawa na online sa pamamagitan
                                    ng aming mobile app. Kailangan mo lang mag-download ng app, magparehistro at mag-upload
                                    ng mga kinakailangang dokumento tulad ng valid government ID at patunay ng paninirahan.
                                    Magkakaroon kami sa inyo kung kailan ito pwedeng kunin sa barangay hall.</p>
                                <p class="text-xs text-gray-300 mt-1">11:18 AM</p>
                            </div>
                            <div class="text-xs bg-gray-200 rounded-full px-2 py-1">AD</div>
                        </div>

                        <!-- User Message -->
                        <div class="flex items-start space-x-2">
                            <img src="https://ui-avatars.com/api/?name=Maria+Santos" class="user-avatar w-8 h-8"
                                alt="Maria">
                            <div class="message-bubble user-message">
                                <p>Ah, naintindihan ko. Paano ko malalaman kung approved na ang request ko? May bayad po ba
                                    ito?</p>
                                <p class="text-xs text-gray-500 mt-1">11:19 AM</p>
                            </div>
                        </div>

                        <!-- Admin Message -->
                        <div class="flex items-start justify-end space-x-2">
                            <div class="message-bubble admin-message">
                                <p>Kapag inaprubahan na po ang request mo makakatanggap ka ng confirmation message sa app.
                                    Kapag magpapakuha na ng ID, kailangan mo lang pumunta sa barangay hall kung kailan mo
                                    ito pwedeng kunin. Ang processing time ay 2-3 working days. May bayad na 50 pesos para
                                    sa ID. Sana ito ay nakatulong!</p>
                                <p class="text-xs text-gray-300 mt-1">11:20 AM</p>
                            </div>
                            <div class="text-xs bg-gray-200 rounded-full px-2 py-1">AD</div>
                        </div>
                    </div>

                    <!-- Message Input -->
                    <div class="p-4 border-t">
                        <form class="flex space-x-3">
                            <input type="text" placeholder="Type your message..."
                                class="flex-1 border rounded-full py-2 px-4 focus:outline-none focus:border-purple-500">
                            <button type="submit"
                                class="bg-purple-800 text-white rounded-full p-2 w-10 h-10 flex items-center justify-center hover:bg-purple-900">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <!-- Help Desk JS -->
            <script src="{{ asset('js/help-desk.js') }}" defer></script>
        @endpush
    @endsection

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>