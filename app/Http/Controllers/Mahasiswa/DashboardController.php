<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $service)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (! $mahasiswa) {
            abort(403, 'Profil mahasiswa tidak ditemukan.');
        }

        return view('mahasiswa.dashboard', [
            'mahasiswa' => $mahasiswa,
            'sksDiambil' => $service->getStatSks($mahasiswa),
            'ipSemester' => $service->getIps($mahasiswa),
            'ipk' => $service->getIpk($mahasiswa),
            'ipTrend' => $service->getIpTrend($mahasiswa),
            'sksTrend' => $service->getSksTrend($mahasiswa),
            'nilaiSemesterIni' => $service->getNilaiSemesterIni($mahasiswa),
        ]);
    }
}
