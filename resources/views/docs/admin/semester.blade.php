@extends('docs.layouts.main')
@section('title', 'Manajemen Semester — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / Semester</span>
@endsection
@section('content')
<h2>Manajemen Semester</h2>

<p>Mengelola semester akademik, termasuk periode KRS dan status aktif.</p>

<h3>Data yang Dikelola</h3>
<table>
    <tr><th>Field</th><th>Keterangan</th></tr>
    <tr><td>Nama</td><td>Nama semester (contoh: Semester Ganjil 2024/2025)</td></tr>
    <tr><td>Tahun Ajaran</td><td>Tahun akademik</td></tr>
    <tr><td>Tipe</td><td>Ganjil / Genap</td></tr>
    <tr><td>Tanggal Mulai / Selesai</td><td>Periode perkuliahan</td></tr>
    <tr><td>KRS Mulai / Selesai</td><td>Periode pengisian KRS</td></tr>
    <tr><td>Aktif</td><td>Hanya satu semester bisa aktif</td></tr>
</table>

<h3>Fitur Penting</h3>
<h4>Semester Aktif</h4>
<p>Semester aktif menentukan data yang tampil di dashboard, periode KRS, dan kelas yang tersedia. Hanya satu semester yang dapat aktif.</p>

<h4>Periode KRS</h4>
<p>Tanggal KRS Mulai dan Selesai menentukan kapan mahasiswa bisa mengisi KRS. Sistem otomatis membuka/menutup akses berdasarkan tanggal ini.</p>

<h3>Cara Tambah Semester</h3>
<ol>
    <li>Buka menu <strong>Semester</strong></li>
    <li>Klik <strong>Tambah Semester</strong></li>
    <li>Isi data semester, centang Aktif jika ini semester berjalan</li>
    <li>Klik <strong>Simpan</strong></li>
</ol>

<blockquote>Pastikan tanggal KRS diatur sebelum mengaktifkan semester. Tanpa tanggal KRS, mahasiswa tidak bisa mengisi KRS.</blockquote>
@endsection
