<!-- AI Chat Widget -->
<style>
    /* Custom scrollbar for chat messages */
    .chat-messages-container {
        overflow-y: auto !important;
        overflow-x: hidden;
    }
    .chat-messages-container::-webkit-scrollbar {
        width: 10px;
    }
    .chat-messages-container::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 10px;
    }
    .chat-messages-container::-webkit-scrollbar-thumb {
        background: #9ca3af;
        border-radius: 10px;
        border: 2px solid #f3f4f6;
    }
    .chat-messages-container::-webkit-scrollbar-thumb:hover {
        background: #6b7280;
    }
    /* Firefox scrollbar */
    .chat-messages-container {
        scrollbar-width: thin;
        scrollbar-color: #9ca3af #f3f4f6;
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 640px) {
        .chat-widget-container {
            position: fixed !important;
            bottom: 0 !important;
            right: 0 !important;
            left: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            border-radius: 16px 16px 0 0 !important;
            max-height: 85vh !important;
        }
        .chat-messages-mobile {
            max-height: calc(85vh - 180px) !important;
        }
        .chat-button-mobile {
            bottom: 1rem !important;
            right: 1rem !important;
        }
    }
</style>
<div x-data="chatWidget()" x-init="init()" 
     class="fixed bottom-6 right-6 z-50 chat-button-mobile"
     @keydown.escape="isOpen = false">
    
    <!-- Chat Button (when closed) -->
    <button 
        x-show="!isOpen"
        @click="toggleChat()"
        class="bg-indigo-600 text-white rounded-full p-4 shadow-lg hover:bg-indigo-700 transition-all duration-300 hover:scale-110 flex items-center justify-center group relative">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        <span x-show="unreadCount > 0" 
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold"
              x-text="unreadCount"></span>
        <span class="absolute bottom-full right-0 mb-2 px-3 py-1 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap hidden sm:block">
            Chat with Event Buddy
        </span>
    </button>

    <!-- Chat Window -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4"
        class="bg-white rounded-2xl shadow-2xl w-full sm:w-96 max-h-[600px] flex flex-col overflow-hidden chat-widget-container">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 sm:px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-2 sm:space-x-3">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-base sm:text-lg">Event Buddy</h3>
                    <p class="text-xs text-white/80">
                        <span x-show="isTyping">Typing...</span>
                        <span x-show="!isTyping" class="flex items-center">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                            Online
                        </span>
                    </p>
                </div>
            </div>
            <div class="flex items-center space-x-1 sm:space-x-2">
                <button @click="clearChat()" 
                        class="p-2 hover:bg-white/20 rounded-full transition-colors"
                        title="Clear chat history">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
                <button @click="isOpen = false" 
                        class="p-2 hover:bg-red-100 rounded-full transition-all duration-200 group"
                        title="Close chat">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-900 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="flex-1 overflow-y-auto p-3 sm:p-4 space-y-3 sm:space-y-4 bg-gray-50 scroll-smooth chat-messages-container chat-messages-mobile" 
             x-ref="messagesContainer"
             style="scroll-behavior: smooth; max-height: 400px; min-height: 250px;"
             @scroll="handleScroll()">
            
            <!-- Welcome Message -->
            <div x-show="messages.length === 0" class="text-center py-6 sm:py-8">
                <div class="w-12 h-12 sm:w-16 sm:h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
                    </svg>
                </div>
                <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">👋 Hi! I'm Event Buddy</h4>
                <p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 px-2">Your AI-powered event discovery assistant</p>
                <div class="flex flex-wrap justify-center gap-2">
                    <button @click="sendQuickMessage('Show me events near me')" 
                            class="px-2 sm:px-3 py-1 bg-white border border-gray-200 rounded-full text-xs sm:text-sm hover:bg-gray-50 transition-colors">
                        📍 Events near me
                    </button>
                    <button @click="sendQuickMessage('What events are happening this weekend?')" 
                            class="px-2 sm:px-3 py-1 bg-white border border-gray-200 rounded-full text-xs sm:text-sm hover:bg-gray-50 transition-colors">
                        📅 This weekend
                    </button>
                    <button @click="sendQuickMessage('Show me music events')" 
                            class="px-2 sm:px-3 py-1 bg-white border border-gray-200 rounded-full text-xs sm:text-sm hover:bg-gray-50 transition-colors">
                        🎵 Music events
                    </button>
                    <button @click="sendQuickMessage('Hello')" 
                            class="px-2 sm:px-3 py-1 bg-white border border-gray-200 rounded-full text-xs sm:text-sm hover:bg-gray-50 transition-colors">
                        👋 Say hi
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                    <div class="max-w-[85%] sm:max-w-[80%]">
                        <div class="rounded-2xl px-3 sm:px-4 py-2 sm:py-3 shadow-sm prose prose-sm max-w-none"
                             :class="msg.role === 'user' 
                                 ? 'bg-indigo-600 text-white rounded-br-none prose-invert' 
                                 : 'bg-white text-gray-900 rounded-bl-none'">
                            <div class="text-xs sm:text-sm whitespace-pre-wrap leading-relaxed" 
                                 x-html="formatMarkdown(msg.message)"></div>
                            
                            <!-- Suggested Events -->
                            <div x-show="msg.events && msg.events.length > 0" class="mt-2 sm:mt-3 space-y-2">
                                <template x-for="event in msg.events" :key="event.id">
                                    <a :href="event.url" 
                                       class="block bg-gray-50 hover:bg-gray-100 rounded-lg p-2 sm:p-3 transition-colors text-gray-900 no-underline">
                                        <div class="flex items-start space-x-2 sm:space-x-3">
                                            <div x-show="event.image" class="flex-shrink-0">
                                                <img :src="event.image" :alt="event.name" class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg object-cover">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-medium text-sm truncate" x-text="event.name"></p>
                                                <p class="text-xs text-gray-600 mt-1">
                                                    <span x-text="event.date"></span> • <span x-text="event.venue"></span>
                                                </p>
                                                <p class="text-xs font-semibold text-indigo-600 mt-1" x-text="event.price"></p>
                                            </div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 px-2" x-text="msg.created_at"></p>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isTyping" class="flex justify-start">
                <div class="bg-white rounded-2xl rounded-bl-none px-4 py-3 shadow-sm">
                    <div class="flex space-x-2">
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-200 p-4 bg-white">
            <form @submit.prevent="sendMessage()" class="flex items-end space-x-2">
                <div class="flex-1">
                    <textarea
                        x-model="messageInput"
                        @keydown.enter.prevent="if(!$event.shiftKey) sendMessage()"
                        placeholder="Ask me anything..."
                        rows="1"
                        class="w-full resize-none rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                        :disabled="isTyping"></textarea>
                </div>
                <button 
                    type="submit"
                    :disabled="!messageInput.trim() || isTyping"
                    class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            <p class="text-xs text-gray-500 mt-2 text-center">
                Powered by AI • Press Enter to send
            </p>
        </div>
    </div>
</div>

<script>
function chatWidget() {
    return {
        isOpen: false,
        isTyping: false,
        messageInput: '',
        messages: [],
        unreadCount: 0,
        userLocation: null,

        init() {
            this.loadHistory();
            this.getUserLocation();
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.unreadCount = 0;
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            }
        },

        getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        this.userLocation = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        };
                    },
                    (error) => {
                        console.log('Location access denied or unavailable');
                    }
                );
            }
        },

        async loadHistory() {
            try {
                const response = await fetch('/chat/history');
                const data = await response.json();
                if (data.success) {
                    this.messages = data.messages;
                }
            } catch (error) {
                console.error('Failed to load chat history:', error);
            }
        },

        async sendMessage() {
            if (!this.messageInput.trim()) return;

            const userMessage = this.messageInput.trim();
            this.messageInput = '';

            // Add user message immediately
            this.messages.push({
                role: 'user',
                message: userMessage,
                created_at: 'Just now'
            });

            this.scrollToBottom();
            this.isTyping = true;

            try {
                const payload = {
                    message: userMessage,
                    _token: document.querySelector('meta[name="csrf-token"]')?.content
                };

                // Add location if available
                if (this.userLocation) {
                    payload.latitude = this.userLocation.latitude;
                    payload.longitude = this.userLocation.longitude;
                }

                const response = await fetch('/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (data.success) {
                    this.messages.push({
                        role: 'assistant',
                        message: data.message,
                        events: data.events,
                        created_at: 'Just now'
                    });

                    if (!this.isOpen) {
                        this.unreadCount++;
                    }
                } else {
                    // Handle error response
                    this.messages.push({
                        role: 'assistant',
                        message: data.message || 'Sorry, I encountered an error. Please try again.',
                        created_at: 'Just now'
                    });
                }
            } catch (error) {
                console.error('Chat error:', error);
                this.messages.push({
                    role: 'assistant',
                    message: 'Sorry, I\'m having trouble connecting right now. Please check your internet connection and try again. If the problem persists, our team has been notified.',
                    created_at: 'Just now'
                });
            } finally {
                this.isTyping = false;
                this.scrollToBottom();
            }
        },

        sendQuickMessage(message) {
            this.messageInput = message;
            this.sendMessage();
        },

        async clearChat() {
            if (!confirm('Clear chat history?')) return;

            try {
                const response = await fetch('/chat/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    }
                });

                const data = await response.json();
                if (data.success) {
                    this.messages = [];
                }
            } catch (error) {
                console.error('Failed to clear chat:', error);
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        handleScroll() {
            // Could implement auto-load more messages here
        },

        formatMarkdown(text) {
            if (!text) return '';
            
            // Simple markdown parser
            let formatted = text
                // Bold **text**
                .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                // Italic *text*
                .replace(/\*(.+?)\*/g, '<em>$1</em>')
                // Headers ### text
                .replace(/^### (.+)$/gm, '<h3 class="text-base font-bold mt-2 mb-1">$1</h3>')
                .replace(/^## (.+)$/gm, '<h2 class="text-lg font-bold mt-3 mb-2">$1</h2>')
                .replace(/^# (.+)$/gm, '<h1 class="text-xl font-bold mt-4 mb-2">$1</h1>')
                // Bullet points
                .replace(/^[•\-\*] (.+)$/gm, '<li class="ml-4">$1</li>')
                // Line breaks
                .replace(/\n\n/g, '</p><p class="mt-2">')
                .replace(/\n/g, '<br>');
            
            // Wrap in paragraph if not already wrapped
            if (!formatted.startsWith('<')) {
                formatted = '<p>' + formatted + '</p>';
            }
            
            // Wrap lists
            formatted = formatted.replace(/(<li[^>]*>.*<\/li>)/gs, '<ul class="list-disc my-2">$1</ul>');
            
            return formatted;
        }
    }
}
</script>
