@extends('docs.layouts.main')
@section('title', 'Input Nilai — SIAKAD Mini')
@section('breadcrumb')
    <span>Dosen / Nilai</span>
@endsection
@section('content')
<h2>Input Nilai</h2>

<p>Fitur untuk menginput nilai tugas, UTS, dan UAS mahasiswa per kelas. Sistem menghitung Nilai Akhir (NA) dan Nilai Huruf (NH) secara otomatis berdasarkan bobot tetap.</p>

<h3>Bobot Penilaian</h3>
<table>
    <tr><th>Komponen</th><th>Bobot</th></tr>
    <tr><td>Tugas</td><td>30%</td></tr>
    <tr><td>UTS</td><td>30%</td></tr>
    <tr><td>UAS</td><td>40%</td></tr>
</table>

<h3>Konversi Nilai Akhir ke Huruf</h3>
<table>
    <tr><th>Rentang NA</th><th>Huruf</th><th>Bobot Mutu</th></tr>
    <tr><td>≥ 85</td><td>A</td><td>4.00</td></tr>
    <tr><td>80 — 84</td><td>A-</td><td>3.75</td></tr>
    <tr><td>75 — 79</td><td>B+</td><td>3.50</td></tr>
    <tr><td>70 — 74</td><td>B</td><td>3.00</td></tr>
    <tr><td>65 — 69</td><td>B-</td><td>2.75</td></tr>
    <tr><td>60 — 64</td><td>C+</td><td>2.50</td></tr>
    <tr><td>55 — 59</td><td>C</td><td>2.00</td></tr>
    <tr><td>40 — 54</td><td>D</td><td>1.00</td></tr>
    <tr><td>&lt; 40</td><td>E</td><td>0.00</td></tr>
</table>

<h3>Cara Input Nilai</h3>
<ol>
    <li>Buka menu <strong>Nilai</strong> di sidebar kiri</li>
    <li>Halaman menampilkan daftar kelas yang diampu. Filter semester jika perlu.</li>
    <li>Klik <strong>Input Nilai</strong> pada kelas yang akan dinilai</li>
    <li>Tabel mahasiswa menampilkan kolom: NIM, Nama, Tugas, UTS, UAS, NA, NH</li>
    <li>Masukkan nilai Tugas, UTS, dan UAS (0—100) untuk setiap mahasiswa</li>
    <li>NA dan NH terisi otomatis saat mengetik (kalkulasi real-time via JavaScript)</li>
    <li>Klik <strong>Simpan Semua Nilai</strong></li>
</ol>

<blockquote>Nilai dapat diinput massal sekaligus. Jika NA/NH tidak muncul, pastikan semua kolom nilai terisi. Nilai yang sudah disimpan langsung muncul di KHS mahasiswa.</blockquote>
@endsection
