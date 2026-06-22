<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar — SIAKAD Mini</title>
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
        <div class="relative hidden lg:block min-h-[700px] overflow-hidden">
          <img
            src="https://source.unsplash.com/featured/1200x1600?library,books,study"
            alt="Suasana perpustakaan dan ruang belajar"
            class="absolute inset-0 w-full h-full object-cover"
          >
          <div class="absolute inset-0 bg-stone-900/30"></div>

          <div class="relative z-10 h-full flex flex-col justify-between p-12 text-stone-50">
            <div class="w-10 h-px bg-amber-500 animate-drawLine origin-left"></div>

            <div class="opacity-0 animate-fadeInUp [animation-delay:150ms]">
              <p class="text-[12px] tracking-[0.2em] uppercase text-stone-200 mb-4">Halaman Umum &mdash; 2026</p>
              <h2 class="font-serif text-4xl font-medium tracking-tight leading-snug max-w-sm">
                Mulai dengan ruang yang sederhana.
              </h2>
            </div>
          </div>
        </div>

        <!-- Kanan: form -->
        <div class="flex flex-col justify-center px-8 sm:px-14 py-14 sm:py-16">
          <div class="w-full max-w-sm mx-auto opacity-0 animate-fadeInUp [animation-delay:100ms]">

            <a href="index.html" class="text-[14px] font-semibold tracking-[0.08em] text-stone-900 uppercase hover:text-amber-700 transition-colors duration-300">
              SIAKAD <span class="text-amber-700">Mini</span>
            </a>

            <p class="flex items-center gap-3 text-[12px] tracking-[0.2em] uppercase text-stone-400 mt-10 mb-4">
              <span class="inline-block w-8 h-px bg-amber-700"></span>
              Akun Baru
            </p>
            <h1 class="font-serif text-3xl sm:text-[2.25rem] font-medium tracking-tight text-stone-900 leading-snug">
              Buat akun Anda.
            </h1>
            <p class="mt-3 text-sm text-stone-500 leading-relaxed">
              Lengkapi data singkat berikut untuk membuat akun pada halaman ini.
            </p>

            <form class="mt-9 space-y-6" novalidate>
              <div>
                <label for="name" class="block text-[12px] tracking-[0.15em] uppercase text-stone-400 mb-2">
                  Nama Lengkap
                </label>
                <input
                  id="name"
                  type="text"
                  name="name"
                  placeholder="Nama Anda"
                  class="w-full border border-stone-300 bg-white px-4 py-3 text-[15px] text-stone-900 placeholder-stone-400 focus:outline-none focus:border-stone-900 transition-colors duration-300"
                >
              </div>

              <div>
                <label for="email" class="block text-[12px] tracking-[0.15em] uppercase text-stone-400 mb-2">
                  Alamat Email
                </label>
                <input
                  id="email"
                  type="email"
                  name="email"
                  placeholder="nama@contoh.com"
                  class="w-full border border-stone-300 bg-white px-4 py-3 text-[15px] text-stone-900 placeholder-stone-400 focus:outline-none focus:border-stone-900 transition-colors duration-300"
                >
              </div>

              <div>
                <label for="password" class="block text-[12px] tracking-[0.15em] uppercase text-stone-400 mb-2">
                  Kata Sandi
                </label>
                <input
                  id="password"
                  type="password"
                  name="password"
                  placeholder="&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;"
                  class="w-full border border-stone-300 bg-white px-4 py-3 text-[15px] text-stone-900 placeholder-stone-400 focus:outline-none focus:border-stone-900 transition-colors duration-300"
                >
              </div>

              <div>
                <label for="confirm-password" class="block text-[12px] tracking-[0.15em] uppercase text-stone-400 mb-2">
                  Konfirmasi Kata Sandi
                </label>
                <input
                  id="confirm-password"
                  type="password"
                  name="confirm_password"
                  placeholder="&middot;&middot;&middot;&middot;&middot;&middot;&middot;&middot;"
                  class="w-full border border-stone-300 bg-white px-4 py-3 text-[15px] text-stone-900 placeholder-stone-400 focus:outline-none focus:border-stone-900 transition-colors duration-300"
                >
              </div>

              <label class="flex items-start gap-3 cursor-pointer group">
                <input type="checkbox" name="agree" class="peer sr-only">
                <span class="mt-0.5 w-4 h-4 shrink-0 border border-stone-300 flex items-center justify-center peer-checked:bg-stone-900 peer-checked:border-stone-900 transition-colors duration-300">
                  <span class="w-2 h-2 bg-stone-50 scale-0 peer-checked:scale-100 transition-transform duration-200"></span>
                </span>
                <span class="text-sm text-stone-500 group-hover:text-stone-900 transition-colors duration-300">
                  Saya menyetujui ketentuan penggunaan pada halaman ini
                </span>
              </label>

              <button
                type="submit"
                class="group w-full inline-flex items-center justify-center gap-2 border border-stone-900 bg-stone-900 text-stone-50 px-7 py-3.5 text-[13px] font-medium tracking-wide hover:bg-amber-700 hover:border-amber-700 transition-all duration-300"
              >
                Daftar
                <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
              </button>
            </form>

            <p class="mt-8 text-sm text-stone-500">
              Sudah memiliki akun?
              <a href="login.html" class="text-stone-900 font-medium hover:text-amber-700 transition-colors duration-300 underline decoration-stone-300 hover:decoration-amber-700 underline-offset-4">
                Masuk di sini
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