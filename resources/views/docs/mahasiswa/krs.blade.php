@extends('docs.layouts.main')
@section('title', 'KRS Mahasiswa — SIAKAD Mini')
@section('breadcrumb')
    <span>Mahasiswa / KRS</span>
@endsection
@section('content')
<h2>KRS (Kartu Rencana Studi)</h2>

<p>Fitur untuk memilih mata kuliah yang akan diikuti di semester aktif. KRS hanya dapat diisi dalam periode yang ditentukan oleh admin.</p>

<h3>Syarat &amp; Ketentuan</h3>
<ul>
    <li>KRS hanya dapat diisi saat <strong>periode pengisian KRS</strong> aktif</li>
    <li>Maksimal <strong>24 SKS</strong> per semester</li>
    <li>Jadwal tidak boleh bertabrakan (hari + jam)</li>
    <li>Kelas penuh tidak bisa ditambahkan</li>
</ul>

<h3>Cara Mengisi KRS</h3>
<ol>
    <li>Buka menu <strong>KRS</strong> di sidebar kiri</li>
    <li>Halaman terbagi dua: daftar mata kuliah tersedia dan KRS Saya</li>
    <li>Klik <code>+ Tambah</code> pada mata kuliah yang diinginkan</li>
    <li>Mata kuliah muncul di KRS Saya beserta jadwal dan SKS</li>
    <li>Untuk menghapus, klik ikon <i class="fas fa-trash text-xs text-stone-400"></i> di samping mata kuliah</li>
    <li>Setelah selesai, klik <strong>Ajukan KRS</strong></li>
    <li>Status berubah menjadi <strong>Diajukan</strong>, menunggu persetujuan admin</li>
</ol>

<blockquote>Setelah diajukan, KRS tidak dapat diubah. Hubungi admin jika ada perubahan.</blockquote>

<h3>Status KRS</h3>
<table>
    <tr><th>Status</th><th>Arti</th></tr>
    <tr><td>Draft</td><td>Masih bisa diedit (tambah/hapus mata kuliah)</td></tr>
    <tr><td>Diajukan</td><td>Sudah dikirim ke admin, menunggu persetujuan</td></tr>
    <tr><td>Disetujui</td><td>KRS disetujui, tidak bisa diubah</td></tr>
    <tr><td>Ditolak</td><td>KRS ditolak, lihat catatan untuk perbaikan</td></tr>
</table>

<h3>Tips</h3>
<ul>
    <li>Periksa jadwal agar tidak tabrakan dengan mata kuliah lain</li>
    <li>Pastikan total SKS tidak melebihi 24</li>
    <li>Ajukan KRS segera setelah selesai agar tidak kehabisan kuota</li>
</ul>
@endsection
