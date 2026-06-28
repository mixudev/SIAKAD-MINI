<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->admin = User::where('identifier', 'admin')->first();
});

it('lists akun', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.akun.index'));
    $response->assertStatus(200);
});

it('lists mahasiswa', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.mahasiswa.index'));
    $response->assertStatus(200);
});

it('lists dosen', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dosen.index'));
    $response->assertStatus(200);
});

it('lists mata kuliah', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.mata-kuliah.index'));
    $response->assertStatus(200);
});

it('lists semester', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.semester.index'));
    $response->assertStatus(200);
});

it('lists kelas matkul', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.kelas-matkul.index'));
    $response->assertStatus(200);
});

it('shows admin dashboard', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
    $response->assertStatus(200);
});

it('shows admin KRS approval page', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.krs.index'));
    $response->assertStatus(200);
});

it('shows admin nilai overview page', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.nilai.index'));
    $response->assertStatus(200);
});

it('shows admin KHS page', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.khs.index'));
    $response->assertStatus(200);
});
