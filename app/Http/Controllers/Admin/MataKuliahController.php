<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreMataKuliahRequest;
use App\Http\Requests\Admin\UpdateMataKuliahRequest;
use App\Models\MataKuliah;
use App\Services\MataKuliahService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function __construct(private MataKuliahService $mataKuliahService) {}

    public function index(Request $request): View
    {
        $mataKuliahs = $this->mataKuliahService->list($request->only('search'));

        return view('admin.mata-kuliah.index', compact('mataKuliahs'));
    }

    public function store(StoreMataKuliahRequest $request): RedirectResponse
    {
        $this->mataKuliahService->create($request->validated());

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan');
    }

    public function show(MataKuliah $mataKuliah): View
    {
        return view('admin.mata-kuliah.show', compact('mataKuliah'));
    }

    public function update(UpdateMataKuliahRequest $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $this->mataKuliahService->update($mataKuliah->id, $request->validated());

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Data mata kuliah berhasil diperbarui');
    }

    public function destroy(MataKuliah $mataKuliah): RedirectResponse
    {
        $this->mataKuliahService->delete($mataKuliah->id);

        return redirect()->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus');
    }
}
