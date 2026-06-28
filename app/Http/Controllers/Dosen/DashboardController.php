<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $service)
    {
        $dosen = auth()->user()->dosen;

        if (! $dosen) {
            return view('dosen.dashboard', [
                'kelasCount' => 0,
                'totalMahasiswa' => 0,
                'persentaseNilai' => ['persen' => 0, 'terisi' => 0, 'total' => 0],
                'rataNilai' => collect(),
                'nilaiProgress' => ['terisi' => 0, 'belum' => 0],
                'kelasList' => collect(),
            ]);
        }

        return view('dosen.dashboard', [
            'kelasCount' => $service->getStatKelasDiampu($dosen->id),
            'totalMahasiswa' => $service->getStatTotalMahasiswa($dosen->id),
            'persentaseNilai' => $service->getStatPersentaseNilai($dosen->id),
            'rataNilai' => $service->getRataNilaiPerKelas($dosen->id),
            'nilaiProgress' => $service->getNilaiProgress($dosen->id),
            'kelasList' => $service->getKelasList($dosen->id),
        ]);
    }
}
