<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIAKAD MINI — Dashboard Akademik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(12px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        },
                        slideIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(-16px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
                        },
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.45s ease both',
                        'slide-in': 'slideIn 0.35s ease both',
                    }
                }
            }
        }
    </script>
    <style>
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
</head>

<body class="bg-slate-100 font-sans text-slate-800 antialiased">

    <x-app-popup/>
    <!-- ═══════════════════════════════════════════════
     MOBILE OVERLAY (sidebar toggle)
════════════════════════════════════════════════ -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- ═══════════════════════════════════════════════
     LAYOUT WRAPPER
════════════════════════════════════════════════ -->
    <div class="flex min-h-screen">

        <!-- ─────────────────────────────────────────
        SIDEBAR
        ───────────────────────────────────────── -->
        @include('dashboard.partials.sidebar')

        <!-- ─────────────────────────────────────────
            MAIN AREA
        ───────────────────────────────────────── -->
        <div class="flex-1 flex flex-col lg:ml-64 min-w-0">

            <!-- TOPBAR -->
            @include('dashboard.partials.header')

            <!-- ─────────────────────────────────────────
         PAGE CONTENT
    ───────────────────────────────────────── -->
            <main class="flex-1 px-4 lg:px-8 py-6 space-y-6">

                @yield('content')

            </main>

            <!-- FOOTER -->
            <footer class="border-t border-slate-200 bg-white px-4 lg:px-8 py-4 flex items-center justify-between">
                <p class="text-slate-500 text-xs">© 2026 <span class="font-semibold text-slate-700">SIAKAD MINI</span>
                </p>
                <p class="text-slate-400 text-xs">Sistem Informasi Akademik</p>
            </footer>

        </div><!-- /main area -->
    </div><!-- /layout wrapper -->

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
