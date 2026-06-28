<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDosenRequest;
use App\Http\Requests\Admin\UpdateDosenRequest;
use App\Models\Dosen;
use App\Services\DosenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function __construct(private DosenService $dosenService) {}

    public function index(Request $request): View
    {
        $dosens = $this->dosenService->list($request->only('search'));

        return view('admin.dosen.index', compact('dosens'));
    }

    public function store(StoreDosenRequest $request): RedirectResponse
    {
        $this->dosenService->create($request->validated());

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan');
    }

    public function show(Dosen $dosen): View
    {
        return view('admin.dosen.show', ['dosen' => $dosen->load('user')]);
    }

    public function update(UpdateDosenRequest $request, Dosen $dosen): RedirectResponse
    {
        $this->dosenService->update($dosen->id, $request->validated());

        return redirect()->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        $name = $dosen->nama_lengkap;
        $this->dosenService->delete($dosen->id);

        return redirect()->route('admin.dosen.index')
            ->with('success', "Dosen {$name} berhasil dihapus");
    }
}
