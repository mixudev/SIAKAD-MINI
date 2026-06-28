<?php

use App\Models\KelasMatkul;
use App\Models\Krs;
use App\Models\Semester;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('shows KRS page for mahasiswa', function () {
    $user = User::where('identifier', '220101001')->first();
    $this->assertNotNull($user);

    $response = $this->actingAs($user)->get(route('mahasiswa.krs.index'));
    $response->assertStatus(200);
});

it('allows mahasiswa to add matkul to existing draft KRS', function () {
    $user = User::where('identifier', '220201004')->first();
    $this->assertNotNull($user);
    $mhs = $user->mahasiswa;
    $semester = Semester::aktif();

    $krs = $mhs->krsSemester($semester);
    $this->assertNotNull($krs);
    $beforeCount = $krs->details()->count();

    $kelas = KelasMatkul::where('semester_id', $semester->id)->first();

    $response = $this->actingAs($user)->post(route('mahasiswa.krs.tambah', $kelas));
    $response->assertSessionHas('success');

    $krs->refresh();
    expect($krs->details()->count())->toBe($beforeCount + 1);
});

it('allows mahasiswa to submit draft KRS', function () {
    $user = User::where('identifier', '220201004')->first();
    $this->assertNotNull($user);
    $mhs = $user->mahasiswa;
    $semester = Semester::aktif();

    $krs = $mhs->krsSemester($semester);
    $this->assertEquals('draft', $krs->status);

    $response = $this->actingAs($user)->patch(route('mahasiswa.krs.ajukan', $krs));

    $response->assertSessionHas('success');

    $krs->refresh();
    expect($krs->status)->toBe('diajukan');
});

it('prevents adding duplicate matkul to KRS', function () {
    $user = User::where('identifier', '220201004')->first();
    $this->assertNotNull($user);
    $semester = Semester::aktif();
    $krs = $user->mahasiswa->krsSemester($semester);
    $existingKelasId = $krs->details()->first()?->kelas_matkul_id;

    $kelas = KelasMatkul::find($existingKelasId);

    $response = $this->actingAs($user)->post(route('mahasiswa.krs.tambah', $kelas));

    $response->assertSessionHas('error');
});

it('prevents adding matkul when SKS exceeds max', function () {
    $user = User::where('identifier', '220201004')->first();
    $this->assertNotNull($user);
    $semester = Semester::aktif();
    $krs = $user->mahasiswa->krsSemester($semester);

    $kelasList = KelasMatkul::where('semester_id', $semester->id)
        ->whereNotIn('id', $krs->details->pluck('kelas_matkul_id'))
        ->get();

    foreach ($kelasList as $kelas) {
        $this->actingAs($user)->post(route('mahasiswa.krs.tambah', $kelas));
    }

    $krs->refresh();
    $this->assertLessThanOrEqual(Krs::MAX_SKS, $krs->total_sks);
});

it('allows admin to approve submitted KRS', function () {
    $admin = User::where('identifier', 'admin')->first();
    $mhsUser = User::where('identifier', '220201004')->first();
    $this->assertNotNull($mhsUser);
    $mhs = $mhsUser->mahasiswa;
    $semester = Semester::aktif();

    $krs = $mhs->krsSemester($semester);
    $this->actingAs($mhsUser)->patch(route('mahasiswa.krs.ajukan', $krs));

    $krs->refresh();
    $response = $this->actingAs($admin)->patch(route('admin.krs.approve', $krs));
    $response->assertSessionHas('success');

    $krs->refresh();
    expect($krs->status)->toBe('disetujui');
});

it('allows admin to reject KRS with notes', function () {
    $admin = User::where('identifier', 'admin')->first();
    $mhsUser = User::where('identifier', '220201004')->first();
    $this->assertNotNull($mhsUser);
    $mhs = $mhsUser->mahasiswa;
    $semester = Semester::aktif();

    $krs = $mhs->krsSemester($semester);
    $this->actingAs($mhsUser)->patch(route('mahasiswa.krs.ajukan', $krs));

    $krs->refresh();
    $response = $this->actingAs($admin)->patch(route('admin.krs.tolak', $krs), [
        'catatan' => 'SKS melebihi batas',
    ]);
    $response->assertSessionHas('success');

    $krs->refresh();
    expect($krs->status)->toBe('ditolak');
    expect($krs->catatan)->toBe('SKS melebihi batas');
});

it('prevents admin from approving already processed KRS', function () {
    $admin = User::where('identifier', 'admin')->first();
    $mhsUser = User::where('identifier', '220201004')->first();
    $this->assertNotNull($mhsUser);
    $mhs = $mhsUser->mahasiswa;
    $semester = Semester::aktif();

    $krs = $mhs->krsSemester($semester);
    $this->actingAs($mhsUser)->patch(route('mahasiswa.krs.ajukan', $krs));

    $krs->refresh();
    $this->actingAs($admin)->patch(route('admin.krs.approve', $krs));

    $krs->refresh();
    $response = $this->actingAs($admin)->patch(route('admin.krs.approve', $krs));
    $response->assertSessionHas('error');
});
