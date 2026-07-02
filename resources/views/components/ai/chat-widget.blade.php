@props(['bubble' => false])
<div x-data class="flex flex-1 w-full flex-col min-h-0">
    <!-- HEADER -->
    <div class="border-b border-slate-200 bg-white shrink-0">
        <div class="px-4 py-2.5 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-7 h-7 bg-indigo-100 flex items-center justify-center">
                    <i class="fa-solid fa-robot text-indigo-600 text-xs"></i>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-slate-800 leading-tight">AI Asisten Akademik</h3>
                    <p class="text-[10px] text-slate-400 leading-tight">
                        <span x-show="!$store.chat.isStreaming" class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full inline-block"></span>
                            Siap membantu
                        </span>
                        <span x-show="$store.chat.isStreaming" class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-amber-400 rounded-full inline-block animate-pulse"></span>
                            Mengetik...
                        </span>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-1">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="px-2.5 py-1.5 text-xs text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i>Riwayat
                    </button>
                    <div x-show="open" @click.outside="open = false" class="absolute right-0 top-full mt-1 w-64 bg-white border border-slate-200 shadow-lg z-10 max-h-72 overflow-y-auto">
                        <div class="py-1">
                            <button @click="$store.chat.newChat(); open = false" class="w-full text-left px-3 py-2 text-xs text-indigo-600 hover:bg-indigo-50 transition-colors flex items-center gap-2">
                                <i class="fa-solid fa-plus"></i>Chat Baru
                            </button>
                            <div class="border-t border-slate-100 my-1"></div>
                            <template x-for="conv in $store.chat.conversations" :key="conv.id">
                                <button
                                    @click="$store.chat.loadConversation(conv.id); open = false"
                                    :class="$store.chat.conversationId === conv.id ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50'"
                                    class="w-full text-left px-3 py-2 text-xs transition-colors"
                                >
                                    <div class="truncate" x-text="conv.title"></div>
                                    <div class="text-[10px] text-slate-400 mt-0.5" x-text="conv.created_at ? new Date(conv.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'short'}) : ''"></div>
                                </button>
                            </template>
                            <div x-show="$store.chat.conversations.length === 0" class="text-center py-4 text-xs text-slate-400">
                                Belum ada riwayat
                            </div>
                        </div>
                    </div>
                </div>
                @if($bubble)
                    <button
                        @click="$dispatch('chat-close')"
                        class="w-7 h-7 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all"
                        title="Tutup"
                    >
                        <i class="fa-solid fa-minus text-lg"></i>
                    </button>
                @else
                    <a
                        href="{{ route('dashboard') }}"
                        class="w-7 h-7 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all"
                        title="Kembali ke Dashboard"
                    >
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- MESSAGES -->
    <div class="flex-1 overflow-y-auto px-4 py-5 space-y-4 scroll-smooth" x-ref="chatMessages">
        <template x-for="(msg, i) in $store.chat.messages" :key="i">
            <div
                :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-3"
                x-transition:enter-end="opacity-100 translate-y-0"
            >
                <div :class="msg.role === 'user' ? 'flex-row-reverse' : ''" class="flex items-start gap-2 max-w-[80%]">
                    <!-- Avatar -->
                    <div
            :class="msg.role === 'user'
                ? 'bg-indigo-600'
                : 'bg-slate-200 border border-slate-300'"
                        class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 mt-0.5"
                    >
                        <template x-if="msg.role === 'user'">
                            <i class="fa-solid fa-user text-white text-xs"></i>
                        </template>
                        <template x-if="msg.role === 'assistant'">
                            <i class="fa-solid fa-robot text-indigo-500 text-xs"></i>
                        </template>
                    </div>

                    <!-- Bubble -->
                    <div class="space-y-1">
                        <div
                :class="msg.role === 'user'
                    ? 'bg-indigo-600 text-white'
                    : 'bg-slate-100 text-slate-800 border border-slate-200'"
                            class="px-3.5 py-2 text-sm leading-relaxed"
                        >
                            <p class="whitespace-pre-wrap" x-text="msg.content"></p>
                        </div>
                        <p
                            x-show="msg.role === 'user'"
                            class="text-[10px] text-slate-400 text-right"
                            x-text="new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'})"
                        ></p>
                    </div>
                </div>
            </div>
        </template>

        <!-- Loading indicator -->
        <div x-show="$store.chat.isWaiting" class="flex justify-start">
            <div class="flex items-start gap-2 max-w-[80%]">
                <div class="w-7 h-7 bg-white border border-slate-200 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <i class="fa-solid fa-robot text-indigo-500 text-xs"></i>
                </div>
                <div class="bg-white border border-slate-100 px-4 py-3">
                    <div class="flex gap-1.5">
                        <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                        <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                        <span class="w-2 h-2 bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty state -->
        <div x-show="$store.chat.messages.length === 0 && !$store.chat.isWaiting" class="flex items-center justify-center h-full py-8">
            <div class="text-center max-w-sm">
                <div class="w-16 h-16 bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-comment-dots text-indigo-400 text-2xl"></i>
                </div>
                <h4 class="text-base font-semibold text-slate-800 mb-1">Selamat Datang</h4>
                <p class="text-xs text-slate-400 mb-5 leading-relaxed">Tanya apa pun tentang perkuliahan, nilai, rekomendasi matkul, dan lainnya</p>

                <div class="grid grid-cols-1 gap-1.5">
                    <button @click="$store.chat.quickAsk('Apa rekomendasi mata kuliah untuk saya semester depan?')" class="group flex items-center gap-2.5 px-3.5 py-2.5 bg-white border border-slate-200 hover:border-indigo-300 hover:shadow-sm transition-all text-left">
                        <i class="fa-solid fa-book text-indigo-400 text-xs shrink-0"></i>
                        <span class="text-xs text-slate-600 group-hover:text-slate-800">Rekomendasi Matkul</span>
                    </button>
                    <button @click="$store.chat.quickAsk('Bagaimana cara meningkatkan IPK?')" class="group flex items-center gap-2.5 px-3.5 py-2.5 bg-white border border-slate-200 hover:border-emerald-300 hover:shadow-sm transition-all text-left">
                        <i class="fa-solid fa-chart-line text-emerald-400 text-xs shrink-0"></i>
                        <span class="text-xs text-slate-600 group-hover:text-slate-800">Tips Meningkatkan IPK</span>
                    </button>
                    <button @click="$store.chat.quickAsk('Berapa SKS maksimal yang bisa saya ambil semester ini?')" class="group flex items-center gap-2.5 px-3.5 py-2.5 bg-white border border-slate-200 hover:border-amber-300 hover:shadow-sm transition-all text-left">
                        <i class="fa-solid fa-layer-group text-amber-400 text-xs shrink-0"></i>
                        <span class="text-xs text-slate-600 group-hover:text-slate-800">Info SKS Maksimal</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- INPUT -->
    <div class="border-t border-slate-200 px-4 py-3 shrink-0 bg-white">
        <form @submit.prevent="$store.chat.sendMessage()" class="flex gap-2">
            <div class="flex-1">
                <input
                    x-model="$store.chat.input"
                    type="text"
                    placeholder="Ketik pesan..."
                    :disabled="$store.chat.isStreaming"
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none bg-slate-50 disabled:bg-slate-50 disabled:text-slate-400 transition-all"
                />
            </div>
            <button
                type="submit"
                :disabled="!$store.chat.input.trim() || $store.chat.isStreaming"
                class="px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-500 disabled:opacity-40 disabled:cursor-not-allowed transition-all active:scale-95 flex items-center gap-1.5"
            >
                <span class="hidden sm:inline">Kirim</span>
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </form>
        <p class="text-[10px] text-slate-300 text-center mt-1.5">AI dapat melakukan kesalahan. Verifikasi informasi penting.</p>
    </div>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.store('chat', {
        messages: [],
        conversations: [],
        conversationId: null,
        isWaiting: false,
        isStreaming: false,
        input: '',

        init() {
            this.loadConversations();
        },

        newChat() {
            this.messages = [];
            this.conversationId = crypto.randomUUID();
            Alpine.nextTick(() => this.scrollToBottom());
        },

        async loadConversations() {
            try {
                const res = await fetch('{{ route("ai.conversations") }}');
                const data = await res.json();
                this.conversations = data.conversations || [];
            } catch (e) {
                this.conversations = [];
            }
        },

        async loadConversation(id) {
            this.conversationId = id;
            this.messages = [];
            this.isWaiting = false;
            this.isStreaming = false;
            try {
                const res = await fetch(`{{ url('ai/conversations') }}/${id}`);
                const data = await res.json();
                const msgs = data.messages || [];
                msgs.forEach(m => {
                    if (m.role === 'user') {
                        this.messages.push({ role: 'user', content: m.message });
                    }
                    this.messages.push({ role: 'assistant', content: m.response });
                });
                Alpine.nextTick(() => this.scrollToBottom());
            } catch (e) {
                this.messages.push({ role: 'assistant', content: 'Gagal memuat riwayat chat.' });
            }
        },

        async sendMessage() {
            const msg = this.input.trim();
            if (!msg || this.isStreaming) return;

            if (!this.conversationId) {
                this.conversationId = crypto.randomUUID();
            }

            this.messages.push({ role: 'user', content: msg });
            this.input = '';
            this.isWaiting = true;
            this.isStreaming = true;
            this.scrollToBottom();

            try {
                const response = await fetch('{{ route("ai.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: msg,
                        conversation_id: this.conversationId,
                        stream: true
                    })
                });

                const reader = response.body.getReader();
                const decoder = new TextDecoder();
                let buffer = '';

                this.messages.push({ role: 'assistant', content: '' });
                const aiMsg = this.messages[this.messages.length - 1];

                const read = async () => {
                    const { done, value } = await reader.read();
                    if (done) {
                        this.isStreaming = false;
                        this.isWaiting = false;
                        if (!aiMsg.content) {
                            aiMsg.content = 'Maaf, tidak ada respons. Silakan coba lagi.';
                        }
                        await this.loadConversations();
                        this.scrollToBottom();
                        return;
                    }

                    buffer += decoder.decode(value, { stream: true });
                    const parts = buffer.split('\n');
                    buffer = parts.pop() || '';

                    for (const line of parts) {
                        const trimmed = line.trim();
                        if (!trimmed.startsWith('data: ')) continue;
                        try {
                            const data = JSON.parse(trimmed.slice(6));
                            if (data.type === 'start') {
                                this.isWaiting = false;
                                continue;
                            }
                            if (data.type === 'done') continue;
                            if (data.content) {
                                aiMsg.content += data.content;
                                this.scrollToBottom();
                            }
                        } catch (e) {
                            // skip malformed JSON
                        }
                    }

                    await read();
                };

                await read();
            } catch (e) {
                if (this.messages[this.messages.length - 1]?.role === 'assistant') {
                    this.messages[this.messages.length - 1].content = 'Maaf, terjadi kesalahan. Silakan coba lagi.';
                } else {
                    this.messages.push({ role: 'assistant', content: 'Maaf, terjadi kesalahan. Silakan coba lagi.' });
                }
                this.isStreaming = false;
                this.isWaiting = false;
                this.scrollToBottom();
            }
        },

        quickAsk(text) {
            this.input = text;
            this.sendMessage();
        },

        scrollToBottom() {
            Alpine.nextTick(() => {
                const container = document.querySelector('[x-ref="chatMessages"]');
                if (container) {
                    container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                }
            });
        }
    });
});
</script>