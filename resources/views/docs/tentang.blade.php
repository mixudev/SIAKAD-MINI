@extends('docs.layouts.main')
@section('title', 'Tentang Sistem — SIAKAD Mini')
@section('breadcrumb')
    <span>Tentang Sistem</span>
@endsection
@section('content')
<h2>Tentang SIAKAD Mini</h2>

<p>SIAKAD Mini adalah Sistem Informasi Akademik berbasis web untuk mengelola kegiatan akademik di perguruan tinggi secara digital. Mencakup manajemen data mahasiswa, dosen, mata kuliah, semester, kelas perkuliahan, Kartu Rencana Studi (KRS), penilaian, dan Kartu Hasil Studi (KHS).</p>

<h3>Teknologi</h3>
<table>
    <tr><th>Lapisan</th><th>Teknologi</th></tr>
    <tr><td>Framework</td><td>Laravel 13 (PHP 8.5)</td></tr>
    <tr><td>Database</td><td>MySQL / SQLite</td></tr>
    <tr><td>CSS</td><td>Tailwind CSS v4</td></tr>
    <tr><td>Ikon</td><td>Font Awesome 6.5</td></tr>
    <tr><td>Chart</td><td>Chart.js 4.4.7</td></tr>
    <tr><td>Font</td><td>Inter, Newsreader, JetBrains Mono</td></tr>
</table>

<h3>Pengguna Sistem</h3>
<table>
    <tr><th>Role</th><th>Akses</th><th>Fitur Utama</th></tr>
    <tr><td><strong>Admin</strong></td><td>Semua data</td><td>CRUD semua data, persetujuan KRS, lihat KHS semua mahasiswa</td></tr>
    <tr><td><strong>Dosen</strong></td><td>Data kelas &amp; nilai sendiri</td><td>Dashboard, input nilai per kelas</td></tr>
    <tr><td><strong>Mahasiswa</strong></td><td>Data pribadi</td><td>Dashboard, isi KRS, lihat KHS</td></tr>
</table>

<h3>Fitur Utama</h3>
<ul>
    <li><strong>Manajemen Data Master</strong> — CRUD akun, mahasiswa, dosen, mata kuliah, semester, kelas matkul</li>
    <li><strong>KRS (Kartu Rencana Studi)</strong> — Mahasiswa memilih mata kuliah dan submit untuk disetujui admin</li>
    <li><strong>Penilaian</strong> — Dosen input nilai tugas/UTS/UAS, otomatis kalkulasi nilai akhir dan huruf</li>
    <li><strong>KHS (Kartu Hasil Studi)</strong> — Lihat nilai per semester, IP, IPK kumulatif, transkrip</li>
    <li><strong>Dashboard Analitik</strong> — Visualisasi data dengan Chart.js untuk semua role</li>
</ul>

<h3>Alur Akademik</h3>
<ol>
    <li>Admin input data master (dosen, mahasiswa, mata kuliah, semester, kelas)</li>
    <li>Mahasiswa memilih mata kuliah via KRS dan mengajukan</li>
    <li>Admin menyetujui atau menolak KRS yang diajukan</li>
    <li>Dosen menginput nilai akhir untuk kelas yang diampu</li>
    <li>Mahasiswa melihat hasil studi via KHS per semester</li>
</ol>
@endsection
