<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMahasiswaRequest;
use App\Http\Requests\Admin\UpdateMahasiswaRequest;
use App\Models\Mahasiswa;
use App\Services\MahasiswaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function __construct(private MahasiswaService $mahasiswaService) {}

    public function index(Request $request): View
    {
        $mahasiswas = $this->mahasiswaService->list($request->only('search'));

        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function store(StoreMahasiswaRequest $request): RedirectResponse
    {
        $this->mahasiswaService->create($request->validated());

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function show(Mahasiswa $mahasiswa): View
    {
        return view('admin.mahasiswa.show', ['mhs' => $mahasiswa->load('user')]);
    }

    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $this->mahasiswaService->update($mahasiswa->id, $request->validated());

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $name = $mahasiswa->nama_lengkap;
        $this->mahasiswaService->delete($mahasiswa->id);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', "Mahasiswa {$name} berhasil dihapus");
    }
}
