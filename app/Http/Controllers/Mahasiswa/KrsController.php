<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KelasMatkul;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Semester;
use App\Services\KrsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KrsController extends Controller
{
    public function __construct(private readonly KrsService $krsService) {}

    public function index(): View
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $semester = Semester::aktif();

        if (! $semester) {
            return view('mahasiswa.krs.index', [
                'semester' => null,
                'krs' => null,
                'kelasTersedia' => collect(),
                'error' => 'Tidak ada semester aktif saat ini.',
            ]);
        }

        $krs = $this->krsService->buatAtauAmbilKrs($mahasiswa, $semester);
        $kelasTersedia = $this->krsService->daftarKelasTersedia($mahasiswa, $semester);

        return view('mahasiswa.krs.index', compact('semester', 'krs', 'kelasTersedia'));
    }

    public function tambah(KelasMatkul $kelasMatkul): RedirectResponse
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $semester = Semester::aktif();

        if (! $semester) {
            return back()->with('error', 'Tidak ada semester aktif.');
        }

        if ($kelasMatkul->semester_id !== $semester->id) {
            return back()->with('error', 'Kelas tidak tersedia di semester ini.');
        }

        $krs = $this->krsService->buatAtauAmbilKrs($mahasiswa, $semester);

        try {
            $this->krsService->tambahKelasMatkul($krs, $kelasMatkul);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Mata kuliah berhasil ditambahkan ke KRS.');
    }

    public function hapus(KrsDetail $krsDetail): RedirectResponse
    {
        $krs = $krsDetail->krs;

        if ($krs->mahasiswa_id !== auth()->user()->mahasiswa->id) {
            abort(403);
        }

        try {
            $this->krsService->hapusKelasMatkul($krsDetail);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Mata kuliah berhasil dihapus dari KRS.');
    }

    public function ajukan(Krs $krs): RedirectResponse
    {
        if ($krs->mahasiswa_id !== auth()->user()->mahasiswa->id) {
            abort(403);
        }

        try {
            $this->krsService->ajukanKrs($krs);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'KRS berhasil diajukan.');
    }
}
