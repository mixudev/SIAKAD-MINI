<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>SIAKAD MINI — Dashboard Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.9/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar {
            width: 3px;
        }

        ::-webkit-scrollbar-button {
            display: none;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgb(99 102 241 / 60%);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgb(99 102 241);
        }

        html {
            scrollbar-width: thin;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-100 font-sans text-slate-800 antialiased">

    <!-- ═══════════════════════════════════════════════
     MOBILE OVERLAY (sidebar toggle)
    ════════════════════════════════════════════════ -->
    <div id="overlay" class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- ═══════════════════════════════════════════════
     LAYOUT WRAPPER
    ════════════════════════════════════════════════ -->
    <div class="flex min-h-screen overflow-hidden">

        <!-- ─────────────────────────────────────────
        SIDEBAR
        ───────────────────────────────────────── -->
        @include('dashboard.partials.sidebar')

        <!-- ─────────────────────────────────────────
            MAIN AREA
        ───────────────────────────────────────── -->
        <div class="flex-1 flex flex-col lg:ml-64 min-w-0">

            @include('dashboard.partials.header')

            @hasSection('fullpage')
                <main class="flex-1 flex flex-col overflow-hidden">
                    @yield('content')
                </main>
            @else
                <main class="flex-1 flex flex-col px-4 lg:px-8 py-6 overflow-auto">
                    <div class="space-y-6">
                        @yield('content')
                    </div>
                </main>

                <footer class="border-t border-slate-200 bg-white px-4 lg:px-8 py-4 flex items-center justify-between">
                    <p class="text-slate-500 text-xs">© 2026 <span class="font-semibold text-slate-700">SIAKAD MINI</span>
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('docs.index') }}" class="text-slate-400 hover:text-indigo-600 text-xs transition-colors">
                            <i class="fa-solid fa-book-open mr-1"></i>Dokumentasi
                        </a>
                        <span class="text-slate-300">|</span>
                        <p class="text-slate-400 text-xs">Sistem Informasi Akademik</p>
                    </div>
                </footer>
            @endif

        </div><!-- /main area -->
    </div><!-- /layout wrapper -->

    <x-app-popup />

    @hasSection('fullpage')
        <!-- bubble hidden on fullpage pages -->
    @else
        <x-ai.chat-bubble />
    @endif

    @stack('scripts')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
        }
    </script>

</body>

</html>
