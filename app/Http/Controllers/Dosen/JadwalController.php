<?php

namespace App\Http\Controllers\Dosen;

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
        $dosen = auth()->user()->dosen;

        if (! $dosen) {
            abort(403, 'Profil dosen tidak ditemukan.');
        }

        $semesters = Semester::latest()->get();
        $semesterId = $request->get('semester_id', Semester::aktif()?->id);
        $semester = $semesters->firstWhere('id', $semesterId) ?? Semester::aktif();

        $jadwal = $this->jadwalService->getJadwalDosen($dosen, $semester);
        $daftarHari = $this->jadwalService->getDaftarHari();

        return view('dosen.jadwal.index', compact(
            'jadwal',
            'semesters',
            'semester',
            'daftarHari',
        ));
    }
}
