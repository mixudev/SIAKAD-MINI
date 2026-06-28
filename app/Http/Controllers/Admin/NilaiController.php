<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Services\NilaiService;
use Illuminate\View\View;

class NilaiController extends Controller
{
    public function __construct(private readonly NilaiService $nilaiService) {}

    public function index(): View
    {
        $semesters = Semester::orderByDesc('id')->get();
        $semesterId = request('semester_id', Semester::aktif()?->id);
        $kelasFilter = request('kelas_matkul_id');

        $kelasMatkuls = $this->nilaiService->getKelasMatkulBySemester($semesterId);
        $daftarNilai = $this->nilaiService->getNilaiWithFilters($kelasFilter, $semesterId);
        $semesterAktifId = Semester::aktif()?->id;

        return view('admin.nilai.index', compact('semesters', 'semesterId', 'kelasMatkuls', 'kelasFilter', 'daftarNilai', 'semesterAktifId'));
    }
}
