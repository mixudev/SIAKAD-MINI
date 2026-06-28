<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

it('redirects guests to login page', function () {
    $response = $this->get('/admin/dashboard');
    $response->assertRedirect('/login');
});

it('authenticates admin with correct credentials', function () {
    $response = $this->post('/login', [
        'identifier' => 'admin',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticated();
});

it('redirects admin to admin dashboard after login', function () {
    $user = User::where('identifier', 'admin')->first();
    $this->assertNotNull($user, 'Admin user not found');

    $response = $this->actingAs($user)->get('/admin/dashboard');
    $response->assertStatus(200);
});

it('redirects mahasiswa to mahasiswa dashboard', function () {
    $response = $this->post('/login', [
        'identifier' => '220101001',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('mahasiswa.dashboard'));
});

it('redirects dosen to dosen dashboard', function () {
    $response = $this->post('/login', [
        'identifier' => '0510017801',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('dosen.dashboard'));
});

it('rejects invalid credentials', function () {
    $response = $this->post('/login', [
        'identifier' => 'admin',
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('identifier');
    $this->assertGuest();
});

it('rejects inactive accounts', function () {
    $user = User::where('identifier', 'admin')->first();
    $user->update(['is_active' => false]);

    $response = $this->post('/login', [
        'identifier' => 'admin',
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('identifier');
    $this->assertGuest();
});

it('blocks mahasiswa from admin routes', function () {
    $user = User::where('identifier', '220101001')->first();
    $this->assertNotNull($user, 'Mahasiswa user not found');

    $response = $this->actingAs($user)->get('/admin/dashboard');
    $response->assertStatus(403);
});

it('blocks dosen from mahasiswa routes', function () {
    $user = User::where('identifier', '0510017801')->first();
    $this->assertNotNull($user, 'Dosen user not found');

    $response = $this->actingAs($user)->get('/mahasiswa/dashboard');
    $response->assertStatus(403);
});

it('allows logout', function () {
    $user = User::where('identifier', 'admin')->first();

    $response = $this->actingAs($user)->post('/logout');
    $response->assertRedirect('/login');
    $this->assertGuest();
});
