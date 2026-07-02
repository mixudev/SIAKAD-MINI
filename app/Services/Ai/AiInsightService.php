<?php

namespace App\Services\Ai;

use App\Models\KelasMatkul;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Cache;

class AiInsightService
{
    public function __construct(
        private readonly AiService $aiService,
        private readonly AiPromptBuilder $promptBuilder,
    ) {}

    public function generateInsightAdmin(): string
    {
        $cacheKey = 'ai_insight_admin';

        return Cache::remember($cacheKey, config('ai.cache_ttl'), function () {
            $messages = $this->promptBuilder->buildInsightAdmin();

            return $this->aiService->chat($messages);
        });
    }

    public function generateInsightDosen(int $dosenId): string
    {
        $cacheKey = "ai_insight_dosen_{$dosenId}";

        return Cache::remember($cacheKey, config('ai.cache_ttl'), function () use ($dosenId) {
            $messages = $this->promptBuilder->buildInsightDosen($dosenId);

            return $this->aiService->chat($messages);
        });
    }

    public function generateInsightMahasiswa(Mahasiswa $mahasiswa): string
    {
        $cacheKey = 'ai_insight_mahasiswa_'.$mahasiswa->id;

        return Cache::remember($cacheKey, config('ai.cache_ttl'), function () use ($mahasiswa) {
            $messages = $this->promptBuilder->buildInsightMahasiswa($mahasiswa);

            return $this->aiService->chat($messages);
        });
    }

    public function analyzeGrade(KelasMatkul $kelasMatkul): string
    {
        $cacheKey = 'ai_grade_analysis_'.$kelasMatkul->id;

        return Cache::remember($cacheKey, 600, function () use ($kelasMatkul) {
            $messages = $this->promptBuilder->buildGradeAnalysis($kelasMatkul);

            return $this->aiService->chat($messages);
        });
    }

    public function clearCache(): void
    {
        Cache::forget('ai_insight_admin');
    }
}
