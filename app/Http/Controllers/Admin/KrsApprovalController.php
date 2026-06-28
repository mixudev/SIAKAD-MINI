<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\Semester;
use App\Services\KrsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KrsApprovalController extends Controller
{
    public function __construct(private readonly KrsService $krsService) {}

    public function index(): View
    {
        $semesters = Semester::orderByDesc('id')->get();
        $semesterId = request('semester_id', Semester::aktif()?->id);
        $status = request('status', 'diajukan');

        $daftarKrs = $this->krsService->daftarKrsUntukApproval($semesterId, $status);

        return view('admin.krs.index', compact('semesters', 'semesterId', 'daftarKrs', 'status'));
    }

    public function approve(Krs $krs): RedirectResponse
    {
        try {
            $this->krsService->approveKrs($krs, auth()->id());

            return back()->with('success', 'KRS berhasil disetujui.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function tolak(Request $request, Krs $krs): RedirectResponse
    {
        try {
            $this->krsService->tolakKrs($krs, $request->catatan);

            return back()->with('success', 'KRS berhasil ditolak.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
