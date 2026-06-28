<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dokumentasi') — SIAKAD Mini</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Newsreader', 'serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                },
            },
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        code, pre { font-family: 'JetBrains Mono', monospace; }

        .serif { font-family: 'Newsreader', serif; }

        .doc-content h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1c1917;
            margin-top: 48px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e7e5e4;
            font-family: 'Newsreader', serif;
        }
        .doc-content h3 {
            font-size: 18px;
            font-weight: 600;
            color: #292524;
            margin-top: 36px;
            margin-bottom: 12px;
        }
        .doc-content h4 {
            font-weight: 600;
            color: #44403c;
            margin-top: 24px;
            margin-bottom: 8px;
        }
        .doc-content p {
            font-size: 15px;
            color: #57534e;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        .doc-content ul {
            font-size: 15px;
            color: #57534e;
            line-height: 1.625;
            margin-bottom: 24px;
            padding-left: 0;
            list-style: none;
        }
        .doc-content ul li {
            position: relative;
            padding-left: 28px;
        }
        .doc-content ul li::before {
            content: '';
            position: absolute;
            left: 4px;
            top: 10px;
            width: 6px;
            height: 6px;
            background: #d97706;
        }
        .doc-content ol {
            font-size: 15px;
            color: #57534e;
            line-height: 1.625;
            margin-bottom: 24px;
            padding-left: 0;
            list-style: none;
            counter-reset: step;
        }
        .doc-content ol li {
            position: relative;
            padding-left: 40px;
            margin-bottom: 12px;
            counter-increment: step;
        }
        .doc-content ol li::before {
            content: counter(step);
            position: absolute;
            left: 0;
            top: 0;
            width: 24px;
            height: 24px;
            background: #f5f5f4;
            color: #44403c;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .doc-content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
            font-size: 14px;
        }
        .doc-content th {
            background: #f5f5f4;
            text-align: left;
            padding: 10px 16px;
            font-weight: 600;
            color: #44403c;
            border: 1px solid #e7e5e4;
        }
        .doc-content td {
            padding: 10px 16px;
            color: #57534e;
            border: 1px solid #e7e5e4;
        }
        .doc-content tr:nth-child(even) td {
            background: #fafaf9;
        }
        .doc-content blockquote {
            border-left: 3px solid #b45309;
            background: #fafaf9;
            padding: 16px 10px 16px 20px;
            margin: 24px 0;
            font-size: 14px;
            color: #57534e;
        }
        .doc-content blockquote p {
            font-size: 14px;
            color: #57534e;
            margin-bottom: 0;
        }
        .doc-content blockquote strong {
            color: #292524;
        }
        .doc-content code {
            background: #f5f5f4;
            padding: 2px 6px;
            font-size: 14px;
            color: #292524;
            font-weight: 500;
        }
        .doc-content pre {
            background: #1c1917;
            color: #f5f5f0;
            padding: 20px;
            margin-bottom: 24px;
            overflow-x: auto;
            font-size: 14px;
            line-height: 1.625;
        }
        .doc-content pre code {
            background: transparent;
            color: #f5f5f0;
            padding: 0;
            font-weight: 400;
        }
        .doc-content a {
            color: #b45309;
        }
        .doc-content a:hover {
            color: #78350f;
            text-decoration: underline;
        }
        .doc-content hr {
            border-color: #e7e5e4;
            margin: 40px 0;
        }

        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: #e7e5e4; }
        #sidebar::-webkit-scrollbar-thumb:hover { background: #d6d3d1; }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            font-size: 14px;
            color: #57534e;
            border-left: 3px solid transparent;
            transition: all 150ms;
        }
        .sidebar-link:hover {
            color: #1c1917;
            background: #fafaf9;
            border-color: #d6d3d1;
        }
        .sidebar-link.active {
            color: #92400e;
            background: rgba(255, 237, 213, 0.7);
            border-left: 3px solid #b45309;
            font-weight: 500;
        }
        .sidebar-link.active .sidebar-icon {
            color: #d97706;
        }
        .sidebar-link .sidebar-icon {
            color: #a8a29e;
            width: 16px;
            text-align: center;
            font-size: 12px;
            transition: color 150ms;
        }
        .sidebar-link:hover .sidebar-icon {
            color: #78716c;
        }
    </style>
</head>
<body class="bg-white text-stone-800 antialiased">
    <div class="flex min-h-screen">
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/25 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <aside id="sidebar" class="fixed lg:sticky top-0 left-0 z-30 w-64 h-screen bg-white border-r border-stone-200 overflow-y-auto flex flex-col -translate-x-full lg:translate-x-0 transition-transform duration-200">
            @include('docs.partials.sidebar')
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="sticky top-0 z-10 bg-white/95 backdrop-blur border-b border-stone-200 px-5 lg:px-12 py-3.5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden -ml-1 w-9 h-9 flex items-center justify-center text-stone-500 hover:text-stone-700 hover:bg-stone-100 transition-colors">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    <div class="flex items-center gap-2.5 text-sm">
                        <a href="{{ route('docs.index') }}" class="text-stone-500 hover:text-stone-900 transition-colors font-medium">Dokumentasi</a>
                        @if(View::hasSection('breadcrumb'))
                            <span class="text-stone-300">/</span>
                            <span class="text-stone-600">@yield('breadcrumb')</span>
                        @endif
                    </div>
                </div>
                <a href="{{ url('/') }}" class="text-xs text-stone-400 hover:text-amber-700 transition-colors border border-stone-200 hover:border-amber-700 px-3 py-1.5">
                    <i class="fas fa-arrow-left mr-1.5 text-[10px]"></i>Kembali
                </a>
            </header>

            <main class="flex-1 p-6 lg:p-12 max-w-4xl mx-auto w-full">
                <div class="doc-content">
                    @yield('content')
                </div>
            </main>

            <footer class="border-t border-stone-200 px-5 lg:px-12 py-6">
                <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-stone-400">&copy; {{ date('Y') }} SIAKAD Mini — Sistem Informasi Akademik</p>
                    <div class="flex items-center gap-4">
                        <a href="{{ url('/') }}" class="text-xs text-stone-400 hover:text-amber-700 transition-colors">Aplikasi</a>
                        <span class="text-stone-300">|</span>
                        <a href="{{ route('docs.index') }}" class="text-xs text-stone-400 hover:text-amber-700 transition-colors font-medium">Dokumentasi</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>
