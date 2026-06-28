<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $service)
    {
        $semesterAktif = $service->getSemesterAktif();

        return view('admin.dashboard', [
            'statMahasiswa' => $service->getStatMahasiswa(),
            'statDosen' => $service->getStatDosen(),
            'statMatkulAktif' => $service->getStatMatkulAktif(),
            'semesterAktif' => $semesterAktif,
            'krsMenunggu' => $service->getKrsMenunggu(),
            'krsTrend' => $service->getKrsTrend(),
            'gradeDistribution' => $service->getGradeDistribution(),
            'mahasiswaPerProdi' => $service->getMahasiswaPerProdi(),
            'recentKrs' => $service->getRecentKrs(),
        ]);
    }
}
