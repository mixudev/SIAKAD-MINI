<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreKelasMatkulRequest;
use App\Http\Requests\Admin\UpdateKelasMatkulRequest;
use App\Models\Dosen;
use App\Models\KelasMatkul;
use App\Models\MataKuliah;
use App\Models\Semester;
use App\Services\KelasMatkulService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KelasMatkulController extends Controller
{
    public function __construct(private KelasMatkulService $kelasMatkulService) {}

    public function index(Request $request): View
    {
        $kelasMatkuls = $this->kelasMatkulService->list($request->only('search'));
        $mataKuliahs = MataKuliah::where('is_active', true)->orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama_lengkap')->get();
        $semesters = Semester::latest()->get();

        return view('admin.kelas-matkul.index', compact('kelasMatkuls', 'mataKuliahs', 'dosens', 'semesters'));
    }

    public function store(StoreKelasMatkulRequest $request): RedirectResponse
    {
        $this->kelasMatkulService->create($request->validated());

        return redirect()->route('admin.kelas-matkul.index')
            ->with('success', 'Kelas matkul berhasil ditambahkan');
    }

    public function show(KelasMatkul $kelasMatkul): View
    {
        return view('admin.kelas-matkul.show', ['kelasMatkul' => $kelasMatkul->load(['mataKuliah', 'dosen', 'semester'])]);
    }

    public function update(UpdateKelasMatkulRequest $request, KelasMatkul $kelasMatkul): RedirectResponse
    {
        $this->kelasMatkulService->update($kelasMatkul->id, $request->validated());

        return redirect()->route('admin.kelas-matkul.index')
            ->with('success', 'Data kelas matkul berhasil diperbarui');
    }

    public function destroy(KelasMatkul $kelasMatkul): RedirectResponse
    {
        $this->kelasMatkulService->delete($kelasMatkul->id);

        return redirect()->route('admin.kelas-matkul.index')
            ->with('success', 'Kelas matkul berhasil dihapus');
    }
}
