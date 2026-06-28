<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIAKAD Mini</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Newsreader', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            },
                        },
                        drawLine: {
                            '0%': {
                                transform: 'scaleY(0)'
                            },
                            '100%': {
                                transform: 'scaleY(1)'
                            },
                        },
                    },
                    animation: {
                        fadeInUp: 'fadeInUp 0.9s cubic-bezier(0.16,1,0.3,1) forwards',
                        fadeIn: 'fadeIn 1.2s ease-out forwards',
                        drawLine: 'drawLine 1.1s cubic-bezier(0.16,1,0.3,1) forwards',
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-stone-50 text-stone-800 antialiased font-sans">

    <!-- Header -->
    <header class="border-b border-stone-200 bg-stone-50/80 backdrop-blur-md sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-6 sm:px-10 h-20 flex items-center justify-between">
            <span class="text-[15px] font-semibold tracking-[0.08em] text-stone-900 uppercase">
                SIAKAD <span class="text-amber-700">Mini</span>
            </span>
            <ul class="hidden sm:flex items-center gap-10 text-[13px] font-medium tracking-wide text-stone-500">
                <li>
                    <a href="#tentang" class="relative py-2 hover:text-stone-900 transition-colors duration-300 group">
                        Tentang
                        <span
                            class="absolute left-0 -bottom-0.5 h-px w-full bg-stone-900 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></span>
                    </a>
                </li>
                <li>
                    <a href="#informasi"
                        class="relative py-2 hover:text-stone-900 transition-colors duration-300 group">
                        Informasi
                        <span
                            class="absolute left-0 -bottom-0.5 h-px w-full bg-stone-900 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></span>
                    </a>
                </li>
                <li>
                    <a href="#kontak" class="relative py-2 hover:text-stone-900 transition-colors duration-300 group">
                        Kontak
                        <span
                            class="absolute left-0 -bottom-0.5 h-px w-full bg-stone-900 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></span>
                    </a>
                </li>
                <li>
                    <a href="/login" class="relative py-2 hover:text-stone-900 transition-colors duration-300 group">
                        Login
                        <span
                            class="absolute left-0 -bottom-0.5 h-px w-full bg-stone-900 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></span>
                    </a>
                </li>

            </ul>
            <a href="#informasi"
                class="sm:hidden text-[13px] font-medium text-stone-500 hover:text-stone-900 transition-colors duration-300">Menu</a>
        </nav>
    </header>

    <main>
        <!-- Hero -->
        <section class="relative max-w-7xl mx-auto px-6 sm:px-10 pt-28 pb-24 sm:pt-40 sm:pb-32 overflow-hidden">
            <!-- garis dekoratif tipis, bukan ilustrasi -->
            <div class="absolute top-0 left-6 sm:left-10 w-px h-16 bg-stone-300 origin-top animate-drawLine"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-6 items-end">
                <div class="lg:col-span-8 opacity-0 animate-fadeInUp">
                    <p class="flex items-center gap-3 text-[12px] tracking-[0.2em] uppercase text-stone-400 mb-8">
                        <span class="inline-block w-8 h-px bg-amber-700"></span>
                        Halaman Umum &mdash; 2026
                    </p>
                    <h1
                        class="font-serif text-[2.75rem] sm:text-6xl lg:text-7xl font-medium tracking-tight text-stone-900 leading-[1.05]">
                        Ruang informasi<br class="hidden sm:block"> akademik yang tenang<br class="hidden sm:block"> dan
                        sederhana.
                    </h1>
                </div>
                <div class="lg:col-span-4 opacity-0 animate-fadeInUp [animation-delay:150ms]">
                    <p class="text-base sm:text-lg text-stone-500 leading-relaxed border-l border-stone-300 pl-6">
                        Sebuah halaman dengan struktur yang jelas, dirancang untuk menampilkan informasi secara rapi
                        tanpa gangguan visual yang berlebihan.
                    </p>
                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <a href="#informasi"
                            class="group inline-flex items-center gap-2 border border-stone-900 bg-stone-900 text-stone-50 px-7 py-3.5 text-[13px] font-medium tracking-wide hover:bg-amber-700 hover:border-amber-700 transition-all duration-300">
                            Lihat Informasi
                            <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                        </a>
                        <a href="#tentang"
                            class="inline-flex items-center border border-stone-300 px-7 py-3.5 text-[13px] font-medium tracking-wide text-stone-700 hover:border-stone-900 hover:text-stone-900 transition-colors duration-300">
                            Tentang Halaman
                        </a>
                    </div>
                </div>
            </div>

            <div
                class="mt-24 sm:mt-28 grid grid-cols-2 sm:grid-cols-4 gap-8 sm:gap-12 border-t border-stone-200 pt-10 opacity-0 animate-fadeInUp [animation-delay:300ms]">
                <div>
                    <p class="font-serif text-3xl sm:text-4xl text-stone-900">01</p>
                    <p class="mt-2 text-[13px] tracking-wide text-stone-400 uppercase">Struktur Jelas</p>
                </div>
                <div>
                    <p class="font-serif text-3xl sm:text-4xl text-stone-900">02</p>
                    <p class="mt-2 text-[13px] tracking-wide text-stone-400 uppercase">Ruang Lega</p>
                </div>
                <div>
                    <p class="font-serif text-3xl sm:text-4xl text-stone-900">03</p>
                    <p class="mt-2 text-[13px] tracking-wide text-stone-400 uppercase">Tipografi Rapi</p>
                </div>
                <div>
                    <p class="font-serif text-3xl sm:text-4xl text-stone-900">04</p>
                    <p class="mt-2 text-[13px] tracking-wide text-stone-400 uppercase">Responsif Penuh</p>
                </div>
            </div>
        </section>

        <!-- Tentang -->
        <section id="tentang" class="border-t border-stone-200 bg-white">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 py-24 sm:py-32">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                    <div class="lg:col-span-4 opacity-0 animate-fadeInUp">
                        <p class="flex items-center gap-3 text-[12px] tracking-[0.2em] uppercase text-stone-400 mb-6">
                            <span class="inline-block w-8 h-px bg-amber-700"></span>
                            Tentang
                        </p>
                        <h2
                            class="font-serif text-3xl sm:text-4xl font-medium tracking-tight text-stone-900 leading-snug">
                            Disusun untuk kejelasan, bukan untuk pamer.
                        </h2>
                    </div>
                    <div class="lg:col-span-7 lg:col-start-6 opacity-0 animate-fadeInUp [animation-delay:120ms]">
                        <p class="text-lg text-stone-500 leading-relaxed">
                            Halaman ini berfungsi sebagai contoh tata letak umum yang netral. Kontennya bersifat generik
                            dan dapat disesuaikan sesuai kebutuhan, tanpa menonjolkan klaim tertentu maupun penjelasan
                            teknis dari sistem yang lebih luas.
                        </p>
                        <p class="mt-6 text-lg text-stone-500 leading-relaxed">
                            Fokus utama dari tampilan ini adalah keterbacaan, kerapian susunan, dan ruang kosong yang
                            cukup agar setiap bagian terasa lega dan mudah diikuti.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Informasi Umum (cards) -->
        <section id="informasi" class="border-t border-stone-200">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 py-24 sm:py-32">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-16">
                    <div class="lg:col-span-5 opacity-0 animate-fadeInUp">
                        <p class="flex items-center gap-3 text-[12px] tracking-[0.2em] uppercase text-stone-400 mb-6">
                            <span class="inline-block w-8 h-px bg-amber-700"></span>
                            Informasi Umum
                        </p>
                        <h2
                            class="font-serif text-3xl sm:text-4xl font-medium tracking-tight text-stone-900 leading-snug">
                            Beberapa blok ruang yang dapat diisi sesuai kebutuhan.
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 border border-stone-200">
                    <div
                        class="group p-10 bg-white hover:bg-stone-900 transition-colors duration-500 opacity-0 animate-fadeInUp border-b border-r-0 sm:border-r lg:border-r border-stone-200">
                        <span
                            class="font-serif text-sm text-amber-700 group-hover:text-amber-400 transition-colors duration-500">01</span>
                        <h3
                            class="mt-5 text-lg font-medium text-stone-900 group-hover:text-white transition-colors duration-500">
                            Catatan Umum</h3>
                        <p
                            class="mt-3 text-[15px] text-stone-500 group-hover:text-stone-300 leading-relaxed transition-colors duration-500">
                            Ruang ini disediakan untuk keterangan singkat yang bersifat umum.</p>
                    </div>

                    <div
                        class="group p-10 bg-white hover:bg-stone-900 transition-colors duration-500 opacity-0 animate-fadeInUp [animation-delay:80ms] border-b lg:border-r border-stone-200">
                        <span
                            class="font-serif text-sm text-amber-700 group-hover:text-amber-400 transition-colors duration-500">02</span>
                        <h3
                            class="mt-5 text-lg font-medium text-stone-900 group-hover:text-white transition-colors duration-500">
                            Pengumuman</h3>
                        <p
                            class="mt-3 text-[15px] text-stone-500 group-hover:text-stone-300 leading-relaxed transition-colors duration-500">
                            Tempat menampilkan pengumuman atau catatan yang relevan.</p>
                    </div>

                    <div
                        class="group p-10 bg-white hover:bg-stone-900 transition-colors duration-500 opacity-0 animate-fadeInUp [animation-delay:160ms] border-b border-stone-200 sm:border-r-0">
                        <span
                            class="font-serif text-sm text-amber-700 group-hover:text-amber-400 transition-colors duration-500">03</span>
                        <h3
                            class="mt-5 text-lg font-medium text-stone-900 group-hover:text-white transition-colors duration-500">
                            Jadwal</h3>
                        <p
                            class="mt-3 text-[15px] text-stone-500 group-hover:text-stone-300 leading-relaxed transition-colors duration-500">
                            Area kosong untuk informasi terkait jadwal atau linimasa.</p>
                    </div>

                    <div
                        class="group p-10 bg-white hover:bg-stone-900 transition-colors duration-500 opacity-0 animate-fadeInUp [animation-delay:240ms] border-r border-stone-200 sm:border-b lg:border-b-0">
                        <span
                            class="font-serif text-sm text-amber-700 group-hover:text-amber-400 transition-colors duration-500">04</span>
                        <h3
                            class="mt-5 text-lg font-medium text-stone-900 group-hover:text-white transition-colors duration-500">
                            Dokumen</h3>
                        <p
                            class="mt-3 text-[15px] text-stone-500 group-hover:text-stone-300 leading-relaxed transition-colors duration-500">
                            Ruang placeholder untuk referensi dokumen terkait.</p>
                    </div>

                    <div
                        class="group p-10 bg-white hover:bg-stone-900 transition-colors duration-500 opacity-0 animate-fadeInUp [animation-delay:320ms] sm:border-b lg:border-b-0 lg:border-r border-stone-200">
                        <span
                            class="font-serif text-sm text-amber-700 group-hover:text-amber-400 transition-colors duration-500">05</span>
                        <h3
                            class="mt-5 text-lg font-medium text-stone-900 group-hover:text-white transition-colors duration-500">
                            Kontak Unit</h3>
                        <p
                            class="mt-3 text-[15px] text-stone-500 group-hover:text-stone-300 leading-relaxed transition-colors duration-500">
                            Tempat mencantumkan kontak unit terkait jika diperlukan.</p>
                    </div>

                    <div
                        class="group p-10 bg-white hover:bg-stone-900 transition-colors duration-500 opacity-0 animate-fadeInUp [animation-delay:400ms]">
                        <span
                            class="font-serif text-sm text-amber-700 group-hover:text-amber-400 transition-colors duration-500">06</span>
                        <h3
                            class="mt-5 text-lg font-medium text-stone-900 group-hover:text-white transition-colors duration-500">
                            Lainnya</h3>
                        <p
                            class="mt-3 text-[15px] text-stone-500 group-hover:text-stone-300 leading-relaxed transition-colors duration-500">
                            Ruang tambahan yang dapat diisi sesuai kebutuhan lain.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pernyataan netral -->
        <section class="border-t border-stone-200 bg-white">
            <div class="max-w-7xl mx-auto px-6 sm:px-10 py-24 sm:py-32">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    <div class="lg:col-span-1 hidden lg:block opacity-0 animate-fadeInUp">
                        <span class="font-serif text-6xl text-stone-200 leading-none">&ldquo;</span>
                    </div>
                    <blockquote class="lg:col-span-10 opacity-0 animate-fadeInUp [animation-delay:100ms]">
                        <p class="font-serif text-2xl sm:text-3xl lg:text-4xl text-stone-800 leading-snug font-normal">
                            Susunan yang jelas dan ruang yang cukup sering kali lebih membantu dibandingkan tampilan
                            yang dipenuhi elemen visual.
                        </p>
                        <footer
                            class="mt-8 flex items-center gap-4 text-[13px] tracking-wide text-stone-400 uppercase">
                            <span class="inline-block w-8 h-px bg-amber-700"></span>
                            Catatan Desain
                        </footer>
                    </blockquote>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="kontak" class="border-t border-stone-200 bg-stone-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-10 py-16 sm:py-20">
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-10 pb-12 border-b border-stone-200">
                <div class="sm:col-span-5">
                    <span class="text-[15px] font-semibold tracking-[0.08em] text-stone-900 uppercase">
                        SIAKAD <span class="text-amber-700">Mini</span>
                    </span>
                    <p class="mt-4 text-sm text-stone-500 leading-relaxed max-w-xs">
                        Halaman contoh dengan struktur generik, dibuat untuk kebutuhan tampilan yang rapi dan netral.
                    </p>
                </div>
                <div class="sm:col-span-3 sm:col-start-8">
                    <p class="text-[12px] tracking-[0.2em] uppercase text-stone-400 mb-4">Navigasi</p>
                    <ul class="space-y-3 text-sm text-stone-500">
                        <li><a href="#tentang" class="hover:text-stone-900 transition-colors duration-300">Tentang</a>
                        </li>
                        <li><a href="#informasi"
                                class="hover:text-stone-900 transition-colors duration-300">Informasi</a></li>
                    </ul>
                </div>
                <div class="sm:col-span-3">
                    <p class="text-[12px] tracking-[0.2em] uppercase text-stone-400 mb-4">Lainnya</p>
                    <ul class="space-y-3 text-sm text-stone-500">
                        <li><a href="#"
                                class="hover:text-stone-900 transition-colors duration-300">Kebijakan</a></li>
                        <li><a href="#"
                                class="hover:text-stone-900 transition-colors duration-300">Ketentuan</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-[13px] text-stone-400">© 2026 SIAKAD Mini. Hak cipta dilindungi.</p>
                <p class="text-[13px] text-stone-400">Dibuat dengan struktur yang sederhana.</p>
            </div>
        </div>
    </footer>

    <script>
        // Animasi fade-in saat elemen masuk viewport (Intersection Observer)
        // Menggunakan toggle class Tailwind, bukan atribut style.
        const items = document.querySelectorAll('.animate-fadeInUp');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0');
                    entry.target.classList.add('opacity-100');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12
        });
        items.forEach((item) => observer.observe(item));
    </script>
</body>

</html>
