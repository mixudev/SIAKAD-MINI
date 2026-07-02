<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dosen\UpdateNilaiRequest;
use App\Models\KelasMatkul;
use App\Models\Semester;
use App\Services\NilaiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NilaiController extends Controller
{
    public function __construct(private readonly NilaiService $nilaiService) {}

    public function index(): View
    {
        $dosen = auth()->user()->dosen;

        if (! $dosen) {
            return view('dosen.nilai.index', [
                'daftarKelas' => collect(),
                'semesters' => Semester::orderByDesc('id')->get(),
                'semesterId' => request('semester_id', Semester::aktif()?->id),
            ]);
        }

        $semesters = Semester::orderByDesc('id')->get();
        $semesterId = request('semester_id', Semester::aktif()?->id);
        $semester = $semesterId ? Semester::find($semesterId) : null;

        $daftarKelas = $this->nilaiService->daftarKelasDiampu($dosen, $semester);

        return view('dosen.nilai.index', compact('daftarKelas', 'semesters', 'semesterId'));
    }

    public function edit(KelasMatkul $kelasMatkul): View
    {
        if ($kelasMatkul->dosen_id !== auth()->user()->dosen?->id) {
            abort(403);
        }

        $daftarNilai = $this->nilaiService->getNilaiPerKelas($kelasMatkul);

        return view('dosen.nilai.edit', compact('kelasMatkul', 'daftarNilai'));
    }

    public function update(KelasMatkul $kelasMatkul, UpdateNilaiRequest $request): RedirectResponse
    {
        $this->nilaiService->updateNilai(
            $kelasMatkul,
            $request->input('nilai'),
            auth()->id()
        );

        return redirect()->route('dosen.nilai.index')
            ->with('success', 'Nilai berhasil disimpan.');
    }
}
