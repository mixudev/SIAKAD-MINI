@extends('docs.layouts.main')
@section('title', 'Lihat KHS Mahasiswa — SIAKAD Mini')
@section('breadcrumb')
    <span>Admin / KHS</span>
@endsection
@section('content')
<h2>Lihat KHS Mahasiswa</h2>

<p>Admin dapat melihat Kartu Hasil Studi (KHS) mahasiswa mana pun tanpa login sebagai mahasiswa.</p>

<h3>Cara Melihat KHS</h3>
<ol>
    <li>Buka menu <strong>KHS</strong> (grup Akademik)</li>
    <li>Pilih mahasiswa dari dropdown atau cari NIM/nama</li>
    <li>Pilih semester (atau semua semester untuk IPK)</li>
    <li>Klik <strong>Lihat</strong></li>
</ol>

<h3>Informasi yang Ditampilkan</h3>
<ul>
    <li><strong>Tabel Nilai</strong> — Mata kuliah, SKS, nilai huruf, bobot mutu per semester</li>
    <li><strong>IP Semester</strong> — Indeks Prestasi semester tersebut</li>
    <li><strong>IPK</strong> — Indeks Prestasi Kumulatif</li>
    <li><strong>Total SKS</strong> — Total SKS yang sudah ditempuh</li>
    <li><strong>Transkrip</strong> — Riwayat studi lengkap semua semester</li>
</ul>

<blockquote>Berguna untuk memberikan informasi akademik kepada mahasiswa atau keperluan administrasi.</blockquote>
@endsection
