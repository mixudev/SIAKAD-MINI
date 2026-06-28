@extends('docs.layouts.main')
@section('title', 'Persetujuan KRS — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / KRS</span>
@endsection
@section('content')
<h2>Persetujuan KRS</h2>

<p>Menu untuk melihat dan memproses KRS yang diajukan mahasiswa.</p>

<h3>Tampilan Halaman</h3>
<table>
    <tr><th>Kolom</th><th>Keterangan</th></tr>
    <tr><td>Mahasiswa</td><td>Nama dan NIM</td></tr>
    <tr><td>Semester</td><td>Semester diajukan</td></tr>
    <tr><td>Total SKS</td><td>Jumlah SKS yang diambil</td></tr>
    <tr><td>Status</td><td>Draft / Diajukan / Disetujui / Ditolak</td></tr>
    <tr><td>Tanggal</td><td>Tanggal pengajuan</td></tr>
    <tr><td>Aksi</td><td>Detail, Setujui, Tolak</td></tr>
</table>

<h3>Cara Menyetujui KRS</h3>
<ol>
    <li>Buka menu <strong>KRS</strong> (grup Akademik)</li>
    <li>Cari KRS dengan status <strong>Diajukan</strong></li>
    <li>Klik <strong>Detail</strong> untuk lihat mata kuliah yang dipilih</li>
    <li>Klik <strong>Setujui</strong> atau <strong>Tolak</strong> (isi catatan jika menolak)</li>
</ol>

<h3>Alasan Penolakan</h3>
<p>Catatan penolakan akan terlihat mahasiswa sebagai panduan perbaikan:</p>
<ul>
    <li>SKS melebihi 24</li>
    <li>Mata kuliah tidak sesuai program studi</li>
    <li>Jadwal bertabrakan</li>
    <li>Prasyarat belum terpenuhi</li>
</ul>

<blockquote>KRS yang sudah disetujui tidak bisa diubah. Periksa data sebelum menyetujui.</blockquote>
@endsection
