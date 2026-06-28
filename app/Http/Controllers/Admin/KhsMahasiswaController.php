<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Semester;
use App\Services\KhsService;
use Illuminate\View\View;

class KhsMahasiswaController extends Controller
{
    public function __construct(private readonly KhsService $khsService) {}

    public function index(): View
    {
        $mahasiswas = Mahasiswa::with('user')->orderBy('program_studi')->orderBy('nama_lengkap')->get();
        $semesters = Semester::orderByDesc('id')->get();

        $mahasiswaId = request('mahasiswa_id');
        $semesterId = request('semester_id', Semester::aktif()?->id);

        $selectedMahasiswa = $mahasiswaId ? Mahasiswa::with('user')->find($mahasiswaId) : null;
        $selectedSemester = $semesterId ? Semester::find($semesterId) : null;

        $daftarNilai = collect();
        $ipSemester = null;
        $ipk = null;
        $transkrip = collect();

        if ($selectedMahasiswa && $selectedSemester) {
            $daftarNilai = $this->khsService->getKhs($selectedMahasiswa, $selectedSemester);
            $ipSemester = $this->khsService->hitungIpSemester($selectedMahasiswa, $selectedSemester);
            $ipk = $this->khsService->hitungIpk($selectedMahasiswa);

            foreach ($this->khsService->getSemesterList($selectedMahasiswa) as $s) {
                $transkrip->push([
                    'semester' => $s,
                    'ip' => $this->khsService->hitungIpSemester($selectedMahasiswa, $s),
                ]);
            }
        }

        return view('admin.khs.index', compact(
            'mahasiswas', 'semesters', 'mahasiswaId', 'semesterId',
            'selectedMahasiswa', 'selectedSemester',
            'daftarNilai', 'ipSemester', 'ipk', 'transkrip'
        ));
    }
}
