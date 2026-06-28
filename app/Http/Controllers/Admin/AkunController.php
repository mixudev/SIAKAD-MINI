<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAkunRequest;
use App\Http\Requests\Admin\UpdateAkunRequest;
use App\Models\User;
use App\Services\AkunService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AkunController extends Controller
{
    public function __construct(private AkunService $akunService) {}

    public function index(Request $request): View
    {
        $users = $this->akunService->list($request->only('search'));

        return view('admin.akun.index', compact('users'));
    }

    public function store(StoreAkunRequest $request): RedirectResponse
    {
        $this->akunService->create($request->validated());

        return redirect()->route('admin.akun.index')
            ->with('success', 'Akun berhasil dibuat');
    }

    public function show(User $akun): View
    {
        return view('admin.akun.show', ['user' => $akun->load('roles')]);
    }

    public function update(UpdateAkunRequest $request, User $akun): RedirectResponse
    {
        $this->akunService->update($akun->id, $request->validated());

        return redirect()->route('admin.akun.index')
            ->with('success', 'Akun berhasil diperbarui');
    }

    public function destroy(User $akun): RedirectResponse
    {
        $this->akunService->delete($akun->id);

        return redirect()->route('admin.akun.index')
            ->with('success', 'Akun berhasil dihapus');
    }

    public function toggleActive(User $akun): RedirectResponse
    {
        $user = $this->akunService->toggleActive($akun->id);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.akun.index')
            ->with('success', "Akun berhasil {$status}");
    }
}
