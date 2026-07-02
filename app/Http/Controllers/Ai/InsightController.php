<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Models\KelasMatkul;
use App\Services\Ai\AiInsightService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InsightController extends Controller
{
    public function __construct(private readonly AiInsightService $aiInsightService) {}

    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $role = $user->getRoleNames()->first();

        $insight = match ($role) {
            'admin' => $this->aiInsightService->generateInsightAdmin(),
            'dosen' => $user->dosen
                ? $this->aiInsightService->generateInsightDosen($user->dosen->id)
                : 'Profil dosen tidak ditemukan.',
            'mahasiswa' => $user->mahasiswa
                ? $this->aiInsightService->generateInsightMahasiswa($user->mahasiswa)
                : 'Profil mahasiswa tidak ditemukan.',
            default => 'Selamat datang di SIAKAD Mini.',
        };

        return response()->json(['insight' => $insight]);
    }

    public function analyzeGrade(Request $request, KelasMatkul $kelasMatkul): JsonResponse
    {
        $dosen = $request->user()->dosen;

        if (! $dosen || $kelasMatkul->dosen_id !== $dosen->id) {
            abort(403);
        }

        $analysis = $this->aiInsightService->analyzeGrade($kelasMatkul);

        return response()->json(['analysis' => $analysis]);
    }
}
