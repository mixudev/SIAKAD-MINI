<div
    x-data="{ open: false }"
    x-init="open = localStorage.getItem('siakad_chat_open') === 'true'; $watch('open', val => localStorage.setItem('siakad_chat_open', val))"
    @chat-close.window="open = false"
    @toggle-chat-bubble.window="open = !open"
    class="fixed bottom-5 right-5 z-50"
    x-cloak
>
    <!-- Chat Panel -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        @click.outside="open = false"
        class="absolute bottom-16 right-0 w-[22rem] sm:w-96 h-[32rem] sm:max-h-[70vh] bg-white border border-slate-300 shadow-xl flex flex-col overflow-hidden"
    >
        <x-ai.chat-widget :bubble="true" />
    </div>

    <!-- Bubble Button -->
    <button
        @click="open = !open"
        class="w-12 h-12 sm:w-14 sm:h-14 bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg flex items-center justify-center transition-all active:scale-90"
        :class="open ? 'shadow-md' : 'shadow-xl'"
    >
        <template x-if="!open">
            <i class="fa-solid fa-comment-dots text-lg sm:text-xl"></i>
        </template>
        <template x-if="open">
            <i class="fa-solid fa-xmark text-lg sm:text-xl"></i>
        </template>
    </button>
</div>