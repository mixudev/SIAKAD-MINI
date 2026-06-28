@extends('docs.layouts.main')
@section('title', 'KHS Mahasiswa — SIAKAD Mini')
@section('breadcrumb')
    <span>Mahasiswa / KHS</span>
@endsection
@section('content')
<h2>KHS (Kartu Hasil Studi)</h2>

<p>Menampilkan hasil studi per semester, termasuk nilai mata kuliah, Indeks Prestasi (IP), dan IP Kumulatif (IPK).</p>

<h3>Cara Melihat KHS</h3>
<ol>
    <li>Buka menu <strong>KHS</strong> di sidebar kiri</li>
    <li>Pilih semester yang ingin dilihat dari dropdown</li>
    <li>Halaman menampilkan tabel nilai dan ringkasan IP/IPK</li>
</ol>

<h3>Informasi yang Ditampilkan</h3>
<h4>Tabel Nilai per Semester</h4>
<table>
    <tr><th>Kolom</th><th>Keterangan</th></tr>
    <tr><td>No</td><td>Nomor urut</td></tr>
    <tr><td>Kode MK</td><td>Kode mata kuliah</td></tr>
    <tr><td>Mata Kuliah</td><td>Nama mata kuliah</td></tr>
    <tr><td>SKS</td><td>Bobot SKS</td></tr>
    <tr><td>Nilai Huruf</td><td>Nilai akhir (A, A-, B+, dll)</td></tr>
    <tr><td>Bobot Mutu</td><td>Bobot mutu (4.00 — 0.00)</td></tr>
</table>

<h4>Ringkasan</h4>
<ul>
    <li><strong>IP Semester</strong> — Indeks Prestasi semester tersebut</li>
    <li><strong>IPK</strong> — Indeks Prestasi Kumulatif seluruh semester</li>
    <li><strong>Total SKS</strong> — Total SKS yang sudah ditempuh</li>
</ul>

<h3>Transkrip Akademik</h3>
<p>Halaman KHS juga menyediakan transkrip akademik yang menampilkan seluruh riwayat studi dari semester pertama hingga terakhir dalam satu halaman.</p>

<blockquote>Nilai muncul setelah dosen menginput. IP/IPK dihitung otomatis dari bobot mutu dan SKS. Mata kuliah dengan nilai E tetap masuk perhitungan IPK.</blockquote>
@endsection
