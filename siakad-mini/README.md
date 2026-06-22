# SIAKAD Mini

Sistem Informasi Akademik sederhana berbasis Laravel, dengan fitur manajemen akun,
mata kuliah, KRS/KHS, dosen, nilai per komponen, dan manajemen semester.

## Stack

- **Framework**: Laravel 11/12
- **Auth**: Custom manual (NIM/NIDN/Username + Password), tanpa Breeze/Fortify
- **Role & Permission**: [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- **Database**: MySQL (lokal) / PostgreSQL via Supabase atau Neon (production)

## Role Pengguna

| Role | Login Identifier | Akses Utama |
|---|---|---|
| Admin | Username | Kelola semua data: akun, matkul, dosen, semester, approve KRS |
| Dosen | NIDN | Input nilai mahasiswa di kelas yang diampu |
| Mahasiswa | NIM | Isi KRS, lihat KHS, lihat nilai |

## Struktur Database

### Diagram relasi (ringkas)

```
users (auth utama: identifier, password)
 ├── mahasiswas (1:1) ──┬── krs (1:N) ── krs_details (N:1) ── kelas_matkuls
 │                      └── nilais (1:N) ────────────────────┘      │
 └── dosens (1:1) ──────────────────────── kelas_matkuls (1:N) ─────┤
                                                                      │
mata_kuliahs (1:N) ───────────────────────────────────────────────────
semesters (1:N) ── kelas_matkuls
                └── krs
```

### Penjelasan tabel kunci

- **`users`** — tabel auth utama untuk SEMUA role. Kolom `identifier` menampung
  NIM (mahasiswa), NIDN (dosen), atau username (admin). Role sebenarnya
  di-assign lewat Spatie (`$user->assignRole('mahasiswa')`), bukan kolom enum.

- **`kelas_matkuls`** — tabel paling penting di sistem ini. Satu baris = satu
  "kelas" dari sebuah matkul, di semester tertentu, diampu satu dosen.
  Karena satu matkul bisa diampu beberapa dosen dengan kelas/jadwal berbeda,
  matkul yang sama akan punya banyak baris di tabel ini.
  **Mahasiswa mengambil KRS dengan memilih `kelas_matkul`, bukan langsung
  `mata_kuliah`. Nilai juga dicatat per `kelas_matkul`.**

- **`krs`** + **`krs_details`** — header dan detail KRS. Satu mahasiswa hanya
  punya satu baris `krs` per semester (constraint unique). Detail kelas yang
  diambil ada di `krs_details`, dengan snapshot SKS pada saat pengambilan
  (supaya riwayat KRS lama tidak berubah kalau SKS matkul diedit kemudian).

- **`nilais`** — nilai per komponen (tugas/UTS/UAS) per mahasiswa per
  `kelas_matkul`. Kolom `nilai_akhir` dan `nilai_huruf` dihitung **otomatis**
  oleh model (lihat `App\Models\Nilai::booted()`) setiap kali nilai disimpan,
  menggunakan bobot tetap:

  ```
  nilai_akhir = (tugas × 30%) + (uts × 30%) + (uas × 40%)
  ```

  Konversi ke huruf memakai skala standar (A, A-, B+, B, B-, C+, C, D, E).

- **KHS** sengaja **tidak** dibuat sebagai tabel tersendiri — KHS adalah hasil
  rekap nilai per semester, jadi cukup di-query dari `nilais` + `krs` per
  semester (akan dibuat sebagai method/service, bukan tabel fisik, supaya
  tidak ada duplikasi data dengan `nilais`).

### Aturan bisnis yang sudah di-encode di model

- **SKS maksimal KRS**: 24 SKS tetap untuk semua mahasiswa (`Krs::MAX_SKS`).
- **Bobot nilai akhir**: tetap 30% Tugas, 30% UTS, 40% UAS untuk semua matkul
  (`Nilai::BOBOT_TUGAS`, `BOBOT_UTS`, `BOBOT_UAS`).
- Satu mahasiswa hanya boleh punya satu KRS per semester, dan tidak boleh
  mengambil `kelas_matkul` yang sama dua kali dalam satu KRS (database
  constraint, bukan cuma validasi aplikasi).

## Setup Awal

```bash
# 1. Install dependencies
composer install
npm install

# 2. Copy environment file
cp .env.example .env
php artisan key:generate

# 3. Set koneksi database di .env (lihat bagian Database di bawah)

# 4. Jalankan migration
php artisan migrate

# 5. Seed role dasar (admin, dosen, mahasiswa) + akun admin default
php artisan db:seed

# 6. Jalankan dev server
php artisan serve
npm run dev
```

Setelah seeding, akun admin default:
- **Username**: `admin`
- **Password**: `password`

**Wajib ganti password ini sebelum deploy ke production.**

## Konfigurasi Database

### Lokal (MySQL via XAMPP/Docker)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siakad_mini
DB_USERNAME=root
DB_PASSWORD=
```

### Production (Supabase/Neon - PostgreSQL)

```env
DB_CONNECTION=pgsql
DB_HOST=your-host.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

## Yang Belum Dibangun (Tahap Selanjutnya)

Fondasi ini baru mencakup struktur database, model, dan relasi. Belum
termasuk:

- [ ] Controller & route untuk tiap modul (akun, matkul, dosen, KRS, nilai)
- [ ] Logic custom login (deteksi NIM/NIDN/username otomatis dari satu form)
- [ ] Middleware role-based untuk protect route per dashboard
- [ ] View/Blade untuk tiap halaman
- [ ] Validasi SKS max & cek kuota kelas saat pengisian KRS
- [ ] Service untuk generate KHS & transkrip dari data `nilais`
- [ ] Approval flow KRS (mahasiswa ajukan → dosen PA/admin approve)

## Struktur Folder Penting

```
app/Models/
├── User.php           # Auth utama, trait HasRoles (Spatie)
├── Mahasiswa.php       # Profil mahasiswa, relasi ke User
├── Dosen.php           # Profil dosen, relasi ke User
├── Semester.php         # Manajemen semester aktif
├── MataKuliah.php       # Master matkul
├── KelasMatkul.php      # Kelas per matkul-dosen-semester (tabel kunci)
├── Krs.php             # Header KRS per mahasiswa per semester
├── KrsDetail.php        # Detail kelas yang diambil dalam satu KRS
└── Nilai.php           # Nilai per komponen + logic hitung otomatis

database/
├── migrations/         # Urut sesuai dependency tabel
└── seeders/
    ├── RoleSeeder.php    # Role: admin, dosen, mahasiswa
    └── AdminSeeder.php   # Akun admin default
```
