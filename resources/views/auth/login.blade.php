<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk — SIAKAD Mini</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
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
            '0%': { opacity: '0', transform: 'translateY(20px)' },
            '100%': { opacity: '1', transform: 'translateY(0)' },
          },
          fadeIn: {
            '0%': { opacity: '0' },
            '100%': { opacity: '1' },
          },
          drawLine: {
            '0%': { transform: 'scaleY(0)' },
            '100%': { transform: 'scaleY(1)' },
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
<body class="bg-stone-100 text-stone-800 antialiased font-sans">

  <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 py-10 sm:py-16">

    <!-- Box besar di tengah -->
    <div class="w-full max-w-5xl bg-white border border-stone-200 shadow-xl shadow-stone-900/5 opacity-0 animate-fadeIn">
      <div class="grid grid-cols-1 lg:grid-cols-2">

        <!-- Kiri: gambar penuh -->
        <div class="relative hidden lg:block min-h-[440px] overflow-hidden">
          <img
            src="https://source.unsplash.com/featured/1200x1600?university,campus,architecture"
            alt="Suasana kampus dan ruang belajar"
            class="absolute inset-0 w-full h-full object-cover"
          >
          <div class="absolute inset-0 bg-stone-900/30"></div>

          <div class="relative z-10 h-full flex flex-col justify-between p-12 text-stone-50">
            <div class="w-10 h-px bg-amber-500 animate-drawLine origin-left"></div>

            <div class="opacity-0 animate-fadeInUp [animation-delay:150ms]">
              <p class="text-[12px] tracking-[0.2em] uppercase text-stone-200 mb-4">Halaman Umum &mdash; 2026</p>
              <h2 class="font-serif text-4xl font-medium tracking-tight leading-snug max-w-sm">
                Struktur yang tenang untuk setiap sesi.
              </h2>
            </div>
          </div>
        </div>

        <!-- Kanan: form -->
        <div class="flex flex-col justify-center px-8 sm:px-14 py-14 sm:py-16">
          <div class="w-full max-w-sm mx-auto opacity-0 animate-fadeInUp [animation-delay:100ms]">

            <a href="index.html" class="text-[16px] font-semibold tracking-[0.08em] text-stone-900 uppercase hover:text-amber-700 transition-colors duration-300">
              SIAKAD <span class="text-amber-700">Mini</span>
            </a>

            {{-- <p class="flex items-center gap-3 text-[12px] tracking-[0.2em] uppercase text-stone-400 mt-10 mb-4">
              <span class="inline-block w-8 h-px bg-amber-700"></span>
              Akses Akun
            </p>
            <h1 class="font-serif text-3xl sm:text-[2.25rem] font-medium tracking-tight text-stone-900 leading-snug">
              Masuk ke halaman Anda.
            </h1> --}}
            <p class="mt-3 text-sm text-stone-500 leading-relaxed">
              Masukkan kredensial Anda untuk melanjutkan ke halaman ini.
            </p>

            <form class="mt-9 space-y-6" novalidate>
              <div>
                <label for="identifier" class="block text-[12px] tracking-[0.15em] uppercase text-stone-400 mb-2">
                  NIM / Username
                </label>
                <input
                  id="identifier"
                  type="text"
                  name="identifier"
                  placeholder="Masukkan NIM atau username"
                  class="w-full border border-stone-300 bg-white px-4 py-3 text-[15px] text-stone-900 placeholder-stone-400 focus:outline-none focus:border-stone-900 transition-colors duration-300"
                >
              </div>

              <div>
                <div class="flex items-center justify-between mb-2">
                  <label for="password" class="block text-[12px] tracking-[0.15em] uppercase text-stone-400">
                    Kata Sandi
                  </label>
                  <a href="#" class="text-[12px] text-amber-700 hover:text-stone-900 transition-colors duration-300">Lupa?</a>
                </div>
                <input
                  id="password"
                  type="password"
                  name="password"
                  placeholder="&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;"
                  class="w-full border border-stone-300 bg-white px-4 py-3 text-[15px] text-stone-900 placeholder-stone-400 focus:outline-none focus:border-stone-900 transition-colors duration-300"
                >
              </div>

              {{-- <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" name="remember" class="peer sr-only">
                <span class="w-4 h-4 border border-stone-300 flex items-center justify-center peer-checked:bg-stone-900 peer-checked:border-stone-900 transition-colors duration-300">
                  <span class="w-2 h-2 bg-stone-50 scale-0 peer-checked:scale-100 transition-transform duration-200"></span>
                </span>
                <span class="text-sm text-stone-500 group-hover:text-stone-900 transition-colors duration-300">Ingat saya di perangkat ini</span>
              </label> --}}

              <button
                type="submit"
                class="group w-full inline-flex items-center justify-center gap-2 border border-stone-900 bg-stone-900 text-stone-50 px-7 py-3.5 text-[13px] font-medium tracking-wide hover:bg-amber-700 hover:border-amber-700 transition-all duration-300"
              >
                Masuk
                <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
              </button>
            </form>

            <p class="mt-8 text-sm text-stone-500">
              Belum memiliki akun?
              <a href="register.html" class="text-stone-900 font-medium hover:text-amber-700 transition-colors duration-300 underline decoration-stone-300 hover:decoration-amber-700 underline-offset-4">
                Daftar di sini
              </a>
            </p>
          </div>
        </div>

      </div>
    </div>

  </div>

  <script>
    const items = document.querySelectorAll('.animate-fadeInUp, .animate-fadeIn');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.remove('opacity-0');
          entry.target.classList.add('opacity-100');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.05 });
    items.forEach((item) => observer.observe(item));
  </script>
</body>
</html>