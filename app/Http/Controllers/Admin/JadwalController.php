<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Semester;
use App\Services\JadwalService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function __construct(private JadwalService $jadwalService) {}

    public function index(Request $request): View
    {
        $semesters = Semester::latest()->get();
        $semesterId = $request->get('semester_id', Semester::aktif()?->id);
        $semester = $semesters->firstWhere('id', $semesterId) ?? Semester::aktif();

        $dosens = Dosen::orderBy('nama_lengkap')->get();
        $daftarHari = $this->jadwalService->getDaftarHari();

        $jadwal = $this->jadwalService->getSemuaJadwal($semester, $request->only([
            'dosen_id',
            'hari',
            'ruangan',
        ]));

        return view('admin.jadwal.index', compact(
            'jadwal',
            'semesters',
            'semester',
            'dosens',
            'daftarHari',
        ));
    }
}
