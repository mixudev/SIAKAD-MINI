@extends('docs.layouts.main')
@section('title', 'Dashboard Mahasiswa — SIAKAD Mini')
@section('breadcrumb')
    <span>Mahasiswa / Dashboard</span>
@endsection
@section('content')
<h2>Dashboard Mahasiswa</h2>

<p>Dashboard menampilkan ringkasan data akademik dalam bentuk kartu statistik dan grafik interaktif.</p>

<h3>Kartu Statistik</h3>
<table>
    <tr><th>Kartu</th><th>Fungsi</th></tr>
    <tr><td>IP Semester</td><td>Indeks Prestasi semester aktif, dilengkapi label grade (A, B+, dll)</td></tr>
    <tr><td>Total SKS</td><td>Jumlah SKS yang diambil di semester aktif</td></tr>
    <tr><td>Mata Kuliah Aktif</td><td>Jumlah mata kuliah yang sedang diikuti</td></tr>
</table>

<h3>Grafik</h3>
<h4>Grafik Garis — IP per Semester</h4>
<p>Menampilkan tren IP dari semester 1 hingga saat ini. Sumbu X menunjukkan semester, sumbu Y menunjukkan IP (skala 0—4.00). Berguna memantau perkembangan akademik.</p>

<h4>Grafik Batang — SKS per Semester</h4>
<p>Menampilkan jumlah SKS yang diambil setiap semester dalam bentuk batang.</p>

<h3>Tabel Nilai Semester Ini</h3>
<p>Di bawah grafik terdapat tabel mata kuliah semester aktif:</p>
<table>
    <tr><th>Kolom</th><th>Keterangan</th></tr>
    <tr><td>Kode</td><td>Kode mata kuliah</td></tr>
    <tr><td>Mata Kuliah</td><td>Nama mata kuliah</td></tr>
    <tr><td>SKS</td><td>Bobot SKS</td></tr>
    <tr><td>Nilai</td><td>Nilai huruf (A, A-, B+, dll)</td></tr>
    <tr><td>Status</td><td>Lulus / Tidak Lulus</td></tr>
</table>

<blockquote>Nilai hanya muncul setelah dosen menginput dan menyimpan nilai untuk kelas terkait.</blockquote>
@endsection
