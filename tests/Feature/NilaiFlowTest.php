<?php

use App\Models\KelasMatkul;
use App\Models\Nilai;
use App\Models\Semester;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('shows empty nilai page for dosen', function () {
    $user = User::where('identifier', '0510017801')->first();

    $response = $this->actingAs($user)->get(route('dosen.nilai.index'));
    $response->assertStatus(200);
});

it('shows dosen their own kelas only', function () {
    $dosen = User::where('identifier', '0510017801')->first()->dosen;
    $otherKelas = KelasMatkul::where('dosen_id', '!=', $dosen->id)->first();

    if ($otherKelas) {
        $user = User::where('identifier', '0510017801')->first();
        $response = $this->actingAs($user)->get(route('dosen.nilai.edit', $otherKelas));
        $response->assertStatus(403);
    }
});

it('allows dosen to input grades for their class', function () {
    $dosenUser = User::where('identifier', '0510017801')->first();
    $dosen = $dosenUser->dosen;
    $semester = Semester::aktif();

    $kelas = KelasMatkul::where('dosen_id', $dosen->id)
        ->where('semester_id', $semester->id)
        ->first();

    $daftarNilai = $kelas->nilais()->get();

    if ($daftarNilai->isEmpty()) {
        $this->actingAs($dosenUser)->get(route('dosen.nilai.edit', $kelas));
        $daftarNilai = $kelas->nilais()->get();
    }

    if ($daftarNilai->isNotEmpty()) {
        $nilaiData = [];
        foreach ($daftarNilai as $nilai) {
            $nilaiData[$nilai->mahasiswa_id] = [
                'nilai_tugas' => '80',
                'nilai_uts' => '85',
                'nilai_uas' => '90',
            ];
        }

        $response = $this->actingAs($dosenUser)->put(route('dosen.nilai.update', $kelas), [
            'nilai' => $nilaiData,
        ]);
        $response->assertSessionHas('success');

        foreach ($daftarNilai as $nilai) {
            $nilai->refresh();
            expect($nilai->nilai_tugas)->toEqual('80.00');
            expect($nilai->nilai_uts)->toEqual('85.00');
            expect($nilai->nilai_uas)->toEqual('90.00');
            expect($nilai->nilai_akhir)->not->toBeNull();
            expect($nilai->nilai_huruf)->not->toBeNull();
        }
    }
});

it('correctly calculates NA from grade components', function () {
    $nilai = new Nilai;
    $nilai->nilai_tugas = 100;
    $nilai->nilai_uts = 100;
    $nilai->nilai_uas = 100;

    $na = $nilai->hitungNilaiAkhir();
    expect($na)->toBe(100.00);

    $nilai->nilai_tugas = 0;
    $nilai->nilai_uts = 0;
    $nilai->nilai_uas = 0;

    $na = $nilai->hitungNilaiAkhir();
    expect($na)->toBe(0.00);

    $nilai->nilai_tugas = 80;
    $nilai->nilai_uts = 85;
    $nilai->nilai_uas = 90;

    $na = $nilai->hitungNilaiAkhir();

    $expected = (80 * 0.30) + (85 * 0.30) + (90 * 0.40);
    expect($na)->toBe(round($expected, 2));
});

it('correctly converts NA to grade letters', function () {
    $nilai = new Nilai;

    expect($nilai->konversiHuruf(90))->toBe('A');
    expect($nilai->konversiHuruf(85))->toBe('A');
    expect($nilai->konversiHuruf(83))->toBe('A-');
    expect($nilai->konversiHuruf(80))->toBe('A-');
    expect($nilai->konversiHuruf(78))->toBe('B+');
    expect($nilai->konversiHuruf(72))->toBe('B');
    expect($nilai->konversiHuruf(68))->toBe('B-');
    expect($nilai->konversiHuruf(63))->toBe('C+');
    expect($nilai->konversiHuruf(57))->toBe('C');
    expect($nilai->konversiHuruf(42))->toBe('D');
    expect($nilai->konversiHuruf(20))->toBe('E');
    expect($nilai->konversiHuruf(null))->toBeNull();
});

it('correctly calculates bobot mutu', function () {
    $nilai = new Nilai;
    $nilai->nilai_huruf = 'A';
    expect($nilai->bobotMutu())->toBe(4.00);

    $nilai->nilai_huruf = 'A-';
    expect($nilai->bobotMutu())->toBe(3.75);

    $nilai->nilai_huruf = 'B+';
    expect($nilai->bobotMutu())->toBe(3.50);

    $nilai->nilai_huruf = 'B';
    expect($nilai->bobotMutu())->toBe(3.00);

    $nilai->nilai_huruf = 'B-';
    expect($nilai->bobotMutu())->toBe(2.75);

    $nilai->nilai_huruf = 'C+';
    expect($nilai->bobotMutu())->toBe(2.50);

    $nilai->nilai_huruf = 'C';
    expect($nilai->bobotMutu())->toBe(2.00);

    $nilai->nilai_huruf = 'D';
    expect($nilai->bobotMutu())->toBe(1.00);

    $nilai->nilai_huruf = 'E';
    expect($nilai->bobotMutu())->toBe(0.00);
});
