@extends('layouts.app')
@section('title', 'Chat app')

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
    <script>
        // Setup Axios
        window.axios = axios;
        window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        // Setup Echo
        // Setup Echo
        window.Pusher = Pusher;
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env('REVERB_APP_KEY') }}',
            wsHost: '{{ env('REVERB_HOST', 'localhost') }}',
            wsPort: {{ env('REVERB_PORT', 8080) }},
            wssPort: {{ env('REVERB_PORT', 443) }},
            forceTLS: {{ env('REVERB_SCHEME', 'https') === 'https' ? 'true' : 'false' }},
            disableStats: true,
            cluster: 'mt1',
            enabledTransports: ['ws', 'wss'],
        });

        const userId = {{ Auth::user()->id }}; // Defined in blade
        console.log("Chat initialized for user:", userId);

        if (!userId) {
            console.error("UserId not found!");
        } else {
            // Subscribe to private chat channel
            window.Echo.private(`chat.${userId}`)
                .listen(".message.sent", (e) => {
                    console.log("Message received:", e.message);
                    appendMessageToChat(e.message);
                    updateContactList(e.message);
                })
                .listen(".message.read", (e) => {
                    console.log("Message read event:", e);
                    markMessagesAsReadUI(e.recipientId);
                });

            // Subscribe to global users channel for status updates
            window.Echo.private("users").listen(".user.status.updated", (e) => {
                console.log("User status updated:", e.user);
                updateUserStatusUI(e.user);
            });
        }

        // --- Initial Load ---
        document.addEventListener("DOMContentLoaded", () => {
            loadContacts();

            // Search listener
            const searchInput = document.querySelector('.chat-search-input');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value;
                    searchTimeout = setTimeout(() => {
                        loadContacts(query);
                    }, 500); // 500ms debounce
                });
            }
        });

        // --- Logic ---

        function loadContacts(query = '') {
            let url = "/chat/contacts";
            if (query) {
                url += `?q=${encodeURIComponent(query)}`;
            }

            axios.get(url)
                .then((response) => {
                    renderContacts(response.data);
                })
                .catch((error) => {
                    console.error("Error loading contacts:", error);
                });
        }

        function renderContacts(contacts) {
            const contactContainer = document.getElementById("contact");
            if (!contactContainer) return;

            contactContainer.innerHTML = "";

            if (contacts.length === 0) {
                contactContainer.innerHTML =
                    '<li class="chat-contact-list-item"><h6 class="text-muted mb-0">No contacts found</h6></li>';
                return;
            }

            contacts.forEach((contact) => {
                const li = document.createElement("li");
                li.classList.add("chat-contact-list-item");
                li.dataset.contactId = contact.id;
                li.style.cursor = "pointer";
                li.onclick = () => selectContact(contact.id);

                li.innerHTML = `
                    <a class="d-flex align-items-center">
                        <div class="flex-shrink-0 avatar avatar-${contact.status}">
                            <img src="${contact.photo}" alt="Avatar" class="rounded-circle">
                        </div>
                        <div class="chat-contact-info flex-grow-1 ms-2">
                            <h6 class="chat-contact-name text-truncate m-0">${contact.name}</h6>
                            <p class="chat-contact-status text-muted text-truncate mb-0">${contact.role}</p>
                        </div>
                        ${contact.notifCount > 0 ? `<div class="badge bg-danger rounded-pill ms-auto">${contact.notifCount}</div>` : `<div class="badge bg-danger rounded-pill ms-auto d-none">0</div>`}
                    </a>
                `;
                contactContainer.appendChild(li);
            });
        }

        window.selectContact = function(contactId) {
            // Set active class
            document.querySelectorAll(".chat-contact-list-item").forEach((el) => el.classList.remove("active"));
            const activeItem = document.querySelector(`li[data-contact-id="${contactId}"]`);
            if (activeItem) activeItem.classList.add("active");

            // Set hidden input
            const recipientInput = document.getElementById("recipient_id");
            if (recipientInput) recipientInput.value = contactId;

            // Show chat form
            document.getElementById("message-form").classList.remove("d-none");

            // Load history
            loadChatHistory(contactId);

            // Hide "Start chatting" placeholder
            const placeholder = document.querySelector(".fa-address-book");
            if (placeholder && placeholder.parentElement) {
                placeholder.parentElement.classList.add("d-none");
            }
        };

        function loadChatHistory(recipientId) {
            const chatHistoryBody = document.querySelector(".chat-history-body");

            axios.get(`/chat/history/${recipientId}`)
                .then((response) => {
                    const chatHistoryList = document.getElementById("chat-history");
                    chatHistoryList.innerHTML = ""; // Clear current
                    chatHistoryList.classList.remove("d-none");

                    response.data.forEach((msg) => {
                        const li = createMessageElement({
                                message: msg.message,
                                time: msg.time,
                                created_at: msg.createdAt,
                                user_id: msg.senderId,
                                read: msg.read,
                                attachment_url: msg
                                    .attachment_url, // passed from controller? check history method
                                attachment_mime: msg.attachment_mime,
                                attachment_original_name: msg.attachment_original_name,
                                attachment_size: msg.attachment_size
                            },
                            msg.senderId === userId ? "sender" : "recipient",
                        );
                        chatHistoryList.appendChild(li);
                    });

                    scrollToBottom();

                    // Mark as read
                    markAsRead(recipientId);
                })
                .catch((error) => {
                    console.error("Error loading history:", error);
                });
        }

        function markAsRead(recipientId) {
            axios.post("/chat/read", {
                recipient_id: recipientId
            }).then(() => {
                // Update UI: remove badge
                const badge = document.querySelector(`[data-contact-id="${recipientId}"] .badge`);
                if (badge) {
                    badge.textContent = "0";
                    badge.classList.add("d-none");
                }
            });
        }

        // --- UI Interaction ---
        // --- UI Interaction ---
        document.addEventListener("DOMContentLoaded", () => {
            // Initialize PerfectScrollbar
            const chatHistoryBody = document.querySelector('.chat-history-body');
            if (chatHistoryBody && typeof PerfectScrollbar !== 'undefined') {
                new PerfectScrollbar(chatHistoryBody, {
                    wheelPropagation: false,
                    suppressScrollX: true
                });
            }

            const contactList = document.querySelector('.app-chat-contacts .sidebar-body');
            if (contactList && typeof PerfectScrollbar !== 'undefined') {
                new PerfectScrollbar(contactList, {
                    wheelPropagation: false,
                    suppressScrollX: true
                });
            }

            const messageForm = document.getElementById("message-form");
            const messageInput = document.getElementById("message-input");

            if (messageForm) {
                messageForm.addEventListener("submit", (e) => {
                    e.preventDefault();
                    sendMessage();
                });
            }

            if (messageInput) {
                messageInput.addEventListener("keydown", (e) => {
                    if (e.key === "Enter" && !e.shiftKey && !e.ctrlKey) {
                        // Standard Enter sends
                    }
                    if (e.ctrlKey && e.key === "Enter") {
                        e.preventDefault();
                        sendMessage();
                    }
                });

                // Existing focus logic from original file
                messageInput.addEventListener("focus", function() {
                    this.placeholder = "Masukkan pesan";
                });
                messageInput.addEventListener("blur", function() {
                    this.placeholder = "Tulis pesan (ctrl + enter)";
                });
            }

            document.addEventListener('keydown', function(event) {
                if (event.ctrlKey && event.key === 'Enter') {
                    // Logic to focus input if not focused?
                    // Original code: document.querySelector('#message-input').focus();
                    const input = document.querySelector('#message-input');
                    if (input && document.activeElement !== input) {
                        event.preventDefault();
                        input.focus();
                    }
                }
            });
        });

        function sendMessage() {
            const messageInput = document.getElementById("message-input");
            const message = messageInput.value.trim();
            const recipientId = document.getElementById("recipient_id")?.value;
            const fileInput = document.getElementById("attach-doc");
            const file = fileInput?.files[0];

            if (!message && !file) return;
            if (!recipientId) return;

            // Validation: File Size (10MB)
            if (file && file.size > 10 * 1024 * 1024) {
                alert("File too large. Max 10MB.");
                return;
            }

            // UI Elements & State
            const sendBtn = document.querySelector('.send-msg-btn');
            const originalIcon = sendBtn.innerHTML;
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';

            // Optimistic clearing (Text only)
            if (!file) {
                messageInput.value = "";
            }

            const formData = new FormData();
            formData.append('message', message);
            formData.append('recipient_id', recipientId);
            if (file) {
                formData.append('attachment', file);
            }

            axios.post("/chat/send", formData) // Let browser set Content-Type
                .then((response) => {
                    if (response.data.success) {
                        console.log("Message sent:", response.data.message);
                        appendMessageToChat(response.data.message);
                        // Clear inputs
                        messageInput.value = "";
                        if (fileInput) fileInput.value = "";
                    } else {
                        console.error("Failed to send message");
                        alert("Failed to send message");
                        messageInput.value = message; // Restore text
                    }
                })
                .catch((error) => {
                    console.error("Error sending message:", error);
                    alert("Error sending message: " + (error.response?.data?.message || error.message));
                    messageInput.value = message; // Restore text
                })
                .finally(() => {
                    sendBtn.disabled = false;
                    sendBtn.innerHTML = originalIcon;
                });
        }

        function appendMessageToChat(message) {
            const chatHistory = document.getElementById("chat-history");
            const currentRecipientId = document.getElementById("recipient_id")?.value;

            // Only append if we are currently chatting with the sender
            if (currentRecipientId && currentRecipientId == message.user_id) {
                const messageElement = createMessageElement(message, "recipient");
                const placeholder = chatHistory.querySelector(".fa-address-book");
                if (placeholder) {
                    chatHistory.innerHTML = "";
                }
                chatHistory.appendChild(messageElement);
                scrollToBottom();
                markMessagesAsReadUI(message.user_id);
                markAsRead(message.user_id);

            } else if (message.user_id == userId) {
                // My own message
                // Check if I am currently looking at the chat with the recipient of this message
                if (currentRecipientId && currentRecipientId == message.recipient_id) {
                    const messageElement = createMessageElement(message, "sender");
                    const placeholder = chatHistory.querySelector(".fa-address-book");
                    if (placeholder) {
                        chatHistory.innerHTML = "";
                    }
                    chatHistory.appendChild(messageElement);
                    scrollToBottom();
                }
            } else {
                incrementUnreadCount(message.user_id);
            }
        }

        function renderAttachment(message) {
            if (!message.attachment_url) return '';

            if (message.attachment_mime && message.attachment_mime.startsWith('image/')) {
                return `<a href="${message.attachment_url}" target="_blank">
                            <img src="${message.attachment_url}" class="img-fluid rounded mt-2" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                        </a>`;
            } else {
                return `
                    <div class="card mt-2 p-2 border" style="background-color: rgba(255,255,255,0.1); width: fit-content; min-width: 200px;">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-file fa-2xl me-3 text-secondary"></i>
                            <div class="overflow-hidden">
                                <small class="d-block text-truncate fw-bold" style="max-width: 150px;" title="${message.attachment_original_name}">${message.attachment_original_name}</small>
                                <small class="text-muted">${(message.attachment_size / 1024).toFixed(1)} KB</small>
                            </div>
                        </div>
                        <a href="${message.attachment_url}" target="_blank" class="btn btn-sm btn-primary w-100" download>
                            <i class="fa-solid fa-download me-1"></i> Download
                        </a>
                    </div>
                `;
            }
        }

        function createMessageElement(message, type) {
            const li = document.createElement("li");
            li.classList.add("chat-message", type === "sender" ? "chat-message-right" : "chat-message-left");

            let timeDisplay = message.time || "";
            if (!timeDisplay && message.created_at) {
                const date = new Date(message.created_at);
                timeDisplay = date.toLocaleTimeString([], {
                    hour: "2-digit",
                    minute: "2-digit"
                });
            }

            li.innerHTML = `
                <div class="d-flex overflow-hidden">
                    <div class="chat-message-wrapper flex-grow-1">
                        <div class="chat-message-text">
                            <p class="mb-0">${message.message || ''}</p>
                            ${renderAttachment(message)}
                        </div>
                        <div class="text-end text-muted mt-1">
                            <small>${timeDisplay}</small>
                            ${type === "sender" ? `<i class="fa-solid fa-check-double text-${message.read ? "success" : "muted"} ms-2"></i>` : ""}
                        </div>
                    </div>
                </div>
            `;
            return li;
        }

        function scrollToBottom() {
            const chatHistory = document.querySelector(".chat-history-body");
            if (chatHistory) chatHistory.scrollTop = chatHistory.scrollHeight;
        }

        function updateContactList(message) {
            loadContacts();
        }

        function markMessagesAsReadUI(recipientId) {
            const checks = document.querySelectorAll(".fa-check-double.text-muted");
            checks.forEach((check) => {
                check.classList.remove("text-muted");
                check.classList.add("text-success");
            });
        }

        function updateUserStatusUI(user) {
            const contactItem = document.querySelector(`[data-contact-id="${user.id}"]`);
            if (contactItem) {
                const statusBadge = contactItem.querySelector(".avatar");
                if (statusBadge) {
                    // remove old status class? keys are avatar-online, avatar-offline.
                    // simple replacement of class list might be safer if we knew current status.
                    // regex replace?
                    statusBadge.className = statusBadge.className.replace(/avatar-(online|offline|busy|away)/,
                        `avatar-${user.status}`);
                }
            }
        }

        function incrementUnreadCount(senderId) {
            const badge = document.querySelector(`[data-contact-id="${senderId}"] .badge`);
            if (badge) {
                let count = parseInt(badge.textContent || "0");
                badge.textContent = count + 1;
                badge.classList.remove("d-none");
            }
        }
    </script>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-chat.css') }}">
@endsection

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="app-chat card border overflow-hidden">
            <div class="row g-0">
                <!-- Sidebar Left -->
                <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
                    <div
                        class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-6 pt-12">
                        <div class="avatar avatar-xl avatar-{{ $user->status }} chat-sidebar-avatar">
                            <img src="{{ $user->photo }}" alt="Avatar" class="rounded-circle">
                        </div>
                        <h5 class="mt-4 mb-0">{{ $user->name }}</h5>
                        <span>{{ $user->Role->name }}</span>
                        <i class="fa fa-chevron-left cursor-pointer close-sidebar" data-bs-toggle="sidebar" data-overlay
                            data-target="#app-chat-sidebar-left"></i>
                    </div>
                    <form action="{{ route('chat.edit-user', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="sidebar-body px-6 pb-6">
                            <div class="my-6">
                                <label for="chat-sidebar-left-user-about"
                                    class="text-uppercase text-muted mb-1">About</label>
                                <textarea id="chat-sidebar-left-user-about" class="form-control chat-sidebar-left-user-about" rows="3"
                                    maxlength="120" placeholder="Kasi bio dikitt kek biar kerenn" name="bio">{{ $user->bio }}</textarea>
                            </div>
                            <div class="my-6">
                                <p class="text-uppercase text-muted mb-1">Status</p>
                                <div class="d-grid gap-2 pt-2 text-heading ms-2">
                                    <div class="form-check form-check-success">
                                        <input class="form-check-input" type="radio" name="status" value="active"
                                            id="user-active" {{ $user->status == 'online' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user-active">Online</label>
                                    </div>
                                    <div class="form-check form-check-warning">
                                        <input class="form-check-input" type="radio" name="status" value="away"
                                            id="user-away" {{ $user->status == 'away' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user-away">Gabut</label>
                                    </div>
                                    <div class="form-check form-check-danger">
                                        <input class="form-check-input" type="radio" name="status" value="busy"
                                            id="user-busy" {{ $user->status == 'busy' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user-busy">Gabisa diganggu</label>
                                    </div>
                                    <div class="form-check form-check-secondary">
                                        <input class="form-check-input" type="radio" name="status" value="offline"
                                            id="user-offline" {{ $user->status == 'offline' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user-offline">Offline</label>
                                    </div>
                                </div>
                                <div class="my-6">
                                    <button class="btn btn-primary" id="save-status">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /Sidebar Left-->

                <!-- Chat & Contacts -->
                <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                    id="app-chat-contacts">
                    <div class="sidebar-header px-6 border-bottom d-flex align-items-center">
                        <div class="d-flex align-items-center me-6 me-lg-0">
                            <div class="flex-shrink-0 avatar avatar-{{ $user->status }} me-4" data-bs-toggle="sidebar"
                                data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                                <img class="user-avatar rounded-circle cursor-pointer" src="{{ $user->photo }}"
                                    alt="Avatar">
                            </div>
                            <div class="flex-grow-1 input-group input-group-merge rounded-pill">
                                <span class="input-group-text" id="basic-addon-search31"><i
                                        class="fa-solid fa-magnifying-glass"></i></span>
                                <input type="text" class="form-control chat-search-input" placeholder="Search..."
                                    aria-label="Search..." aria-describedby="basic-addon-search31">
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-left cursor-pointer position-absolute top-50 end-0 pe-3 translate-middle d-lg-none d-block"
                            data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
                    </div>
                    <div class="sidebar-body">
                        <!-- Chats -->
                        <ul class="list-unstyled chat-contact-list py-2 mb-0" id="chat-list">
                            <li class="chat-contact-list-item chat-contact-list-item-title mt-0">
                                <h5 class="text-primary mb-0">User</h5>
                            </li>
                            <li class="chat-contact-list-item chat-list-item-0 d-none">
                                <h6 class="text-muted mb-0">Opps...</h6>
                            </li>
                            <div id="contact">

                            </div>
                        </ul>

                    </div>
                </div>
                <!-- /Chat contacts -->

                <!-- Chat History -->
                <div class="col app-chat-history">
                    <div class="chat-history-wrapper">
                        <div class="chat-history-header border-bottom d-block d-lg-none">
                            <div class="d-flex justify-content-between align-items-center" style="min-height:35px">
                                <div class="d-flex overflow-hidden align-items-center">
                                    <i class="fa-solid fa-bars cursor-pointer d-lg-none d-block me-4"
                                        data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history-body">
                            <ul class="list-unstyled chat-history text-center" id="chat-history">
                                <i class="fa-solid fa-address-book text-primary fa-2xl mb-3"></i>
                                <p class="mt-4">Pilih kontak untuk memulai chat</p>
                            </ul>
                        </div>
                        <form class="d-none" id="message-form">
                            <div
                                class="chat-history-footer form-send-message d-flex justify-content-between align-items-center">
                                <input class="form-control message-input border-0 me-4 shadow-none"
                                    placeholder="Tulis pesan (ctrl + enter)" maxlength="500" id="message-input">
                                <div class="message-actions d-flex align-items-center">
                                    <label for="attach-doc" class="form-label mb-0">
                                        <div class="btn btn-icon me-2">
                                            <i
                                                class="fa-solid fa-paperclip-vertical fa-md cursor-pointer mx-1 text-heading"></i>
                                        </div>
                                        <input type="file" id="attach-doc" hidden>
                                    </label>
                                    <button class="btn btn-primary d-flex send-msg-btn">
                                        <span class="align-middle"><i class="fa-solid fa-paper-plane-top"></i></span>
                                        {{-- <i class="fa-solid fa-paper-plane-top ms-md-2 ms-0"></i> --}}
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" id="recipient_id" name="recipient_id">
                        </form>
                    </div>
                </div>
                <!-- /Chat History -->
                <div class="app-overlay"></div>
            </div>
        </div>
    </div>
@endsection
