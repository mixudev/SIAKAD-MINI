<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Services\KhsService;
use Illuminate\View\View;

class KhsController extends Controller
{
    public function __construct(private readonly KhsService $khsService) {}

    public function index(): View
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $semesterList = $this->khsService->getSemesterList($mahasiswa);

        $semesterAktif = Semester::aktif();
        $semesterId = request('semester_id', $semesterAktif?->id);

        $selectedSemester = Semester::find($semesterId);

        $daftarNilai = $selectedSemester
            ? $this->khsService->getKhs($mahasiswa, $selectedSemester)
            : collect();

        $ipSemester = $selectedSemester
            ? $this->khsService->hitungIpSemester($mahasiswa, $selectedSemester)
            : null;

        $ipk = $this->khsService->hitungIpk($mahasiswa);

        $transkrip = collect();
        foreach ($semesterList as $s) {
            $transkrip->push([
                'semester' => $s,
                'ip' => $this->khsService->hitungIpSemester($mahasiswa, $s),
            ]);
        }

        return view('mahasiswa.khs.index', compact(
            'semesterList',
            'selectedSemester',
            'daftarNilai',
            'ipSemester',
            'ipk',
            'transkrip'
        ));
    }

    public function show(Semester $semester): View
    {
        request()->merge(['semester_id' => $semester->id]);

        return $this->index();
    }
}
