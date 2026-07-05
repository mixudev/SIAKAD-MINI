<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Services\JadwalService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function __construct(private JadwalService $jadwalService) {}

    public function index(Request $request): View
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            abort(403, 'Profil mahasiswa tidak ditemukan.');
        }

        $semesters = Semester::latest()->get();
        $semesterId = $request->get('semester_id', Semester::aktif()?->id);
        $semester = $semesters->firstWhere('id', $semesterId) ?? Semester::aktif();

        $jadwal = $this->jadwalService->getJadwalMahasiswa($mahasiswa, $semester);
        $daftarHari = $this->jadwalService->getDaftarHari();

        return view('mahasiswa.jadwal.index', compact(
            'jadwal',
            'semesters',
            'semester',
            'daftarHari',
        ));
    }
}
