<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSemesterRequest;
use App\Http\Requests\Admin\UpdateSemesterRequest;
use App\Models\Semester;
use App\Services\SemesterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SemesterController extends Controller
{
    public function __construct(private SemesterService $semesterService) {}

    public function index(Request $request): View
    {
        $semesters = $this->semesterService->list($request->only('search'));

        return view('admin.semester.index', compact('semesters'));
    }

    public function store(StoreSemesterRequest $request): RedirectResponse
    {
        $this->semesterService->create($request->validated());

        return redirect()->route('admin.semester.index')
            ->with('success', 'Semester berhasil ditambahkan');
    }

    public function show(Semester $semester): View
    {
        return view('admin.semester.show', compact('semester'));
    }

    public function update(UpdateSemesterRequest $request, Semester $semester): RedirectResponse
    {
        $this->semesterService->update($semester->id, $request->validated());

        return redirect()->route('admin.semester.index')
            ->with('success', 'Data semester berhasil diperbarui');
    }

    public function destroy(Semester $semester): RedirectResponse
    {
        try {
            $this->semesterService->delete($semester->id);
        } catch (\RuntimeException $e) {
            return redirect()->route('admin.semester.index')
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.semester.index')
            ->with('success', 'Semester berhasil dihapus');
    }

    public function setActive(Semester $semester): RedirectResponse
    {
        $this->semesterService->setActive($semester->id);

        return redirect()->route('admin.semester.index')
            ->with('success', "Semester {$semester->nama} sekarang aktif");
    }
}
