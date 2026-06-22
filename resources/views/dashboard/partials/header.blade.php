            <header
                class="sticky top-0 z-10 bg-white border-b border-slate-200 px-4 lg:px-8 h-16 flex items-center justify-between gap-4">

                <!-- Left -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()"
                        class="lg:hidden text-slate-500 hover:text-slate-600 transition-colors duration-200">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h2 class="text-slate-900 font-bold text-sm lg:text-base leading-tight">Dashboard Akademik</h2>
                        <nav class="hidden sm:flex items-center gap-1 text-xs text-slate-400">
                            <span>Beranda</span>
                            <i class="fa-solid fa-chevron-right text-slate-300" style="font-size:0.6rem"></i>
                            <span class="text-slate-600 font-medium">Dashboard</span>
                        </nav>
                    </div>
                </div>

                <!-- Right -->
                <div class="flex items-center gap-2 lg:gap-4">
                    <!-- Kalender -->
                    <div
                        class="hidden md:flex items-center gap-2 bg-slate-50 border border-slate-200 px-3 py-1.5 text-xs text-slate-600">
                        <i class="fa-regular fa-calendar text-slate-500"></i>
                        <span>Semester Genap 2025/2026</span>
                    </div>

                    <!-- Notifikasi -->
                    <button
                        class="relative w-9 h-9 flex items-center justify-center text-slate-500 hover:text-slate-600 hover:bg-slate-50 transition-all duration-200 border border-transparent hover:border-slate-100">
                        <i class="fa-regular fa-bell text-base"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 border border-white"></span>
                    </button>

                    <!-- User -->
                    <div class="flex items-center gap-2.5 pl-2 lg:pl-4 border-l border-slate-200">
                        <div class="w-8 h-8 bg-slate-600 flex items-center justify-center">
                            <i class="fa-solid fa-user text-white text-xs"></i>
                        </div>
                        <div class="hidden md:block">
                            <p class="text-slate-800 font-semibold text-xs">Admin Akademik</p>
                            <p class="text-slate-400 text-xs">Super Admin</p>
                        </div>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-xs hidden md:block"></i>
                    </div>
                </div>
            </header>