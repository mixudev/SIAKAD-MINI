---
name: siakad-modular-structure
description: "Use this skill whenever creating or modifying Controllers, Service classes, routes, Form Requests, or Blade views in the SIAKAD mini project. Triggers include: 'buat controller untuk', 'buat fitur CRUD', 'buat halaman', 'tambah route', 'buat service', or any request to implement a feature for one of the modules (akun/users, mata kuliah, dosen, KRS, nilai, semester). Also use when deciding where new application logic should live, or when reviewing whether existing code follows the modular convention. Do NOT use for migration/model/schema work — use siakad-database-conventions for that. Do NOT use for login/role/permission logic — use siakad-auth-role for that."
---

# SIAKAD Mini — Modular Structure Convention

## Overview

This project follows **one module per feature area**, each with its own Controller
and Service class. The pattern is deliberately NOT Repository pattern, and NOT
"fat controllers" with logic inline — it's **Controller (HTTP layer) → Service
(business logic) → Model (data + intrinsic rules)**.

**Never put business logic directly in a Controller method.** A controller method
should read like: validate input → call a Service method → return a response. If a
controller method has more than ~10 lines of logic that isn't validation or response
formatting, that logic belongs in a Service.

## The Modules

| Module | Covers | Roles that touch it |
|---|---|---|
| `Akun` | CRUD users (admin manages all accounts) | Admin |
| `MataKuliah` | CRUD matkul master data | Admin |
| `Dosen` | CRUD dosen profile + assign to kelas_matkul | Admin |
| `Mahasiswa` | CRUD mahasiswa profile | Admin |
| `Semester` | Manage semester, set active semester, open/close KRS period | Admin |
| `KelasMatkul` | Manage class offerings (matkul + dosen + semester + kapasitas) | Admin |
| `Krs` | Mahasiswa fills KRS, admin/dosen approves | Mahasiswa, Admin |
| `Nilai` | Dosen inputs grades per kelas_matkul | Dosen |

Each module gets its own Controller + Service, even if the Service is thin at first.
**Do not merge two modules into one controller** (e.g. don't put Dosen CRUD and
MataKuliah CRUD in the same `AdminController`) — this is the exact "monolith drift"
this skill exists to prevent.

## Folder Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AkunController.php
│   │   │   ├── MataKuliahController.php
│   │   │   ├── DosenController.php
│   │   │   ├── MahasiswaController.php
│   │   │   ├── SemesterController.php
│   │   │   ├── KelasMatkulController.php
│   │   │   └── KrsApprovalController.php      # admin approving KRS, separate from mahasiswa's own KrsController
│   │   ├── Mahasiswa/
│   │   │   ├── KrsController.php              # mahasiswa filling their own KRS
│   │   │   └── KhsController.php              # mahasiswa viewing their own KHS/transkrip
│   │   └── Dosen/
│   │       └── NilaiController.php            # dosen inputting grades for their kelas_matkul
│   ├── Requests/
│   │   ├── Admin/
│   │   │   ├── StoreMataKuliahRequest.php
│   │   │   ├── UpdateMataKuliahRequest.php
│   │   │   └── ...
│   │   ├── Mahasiswa/
│   │   │   └── StoreKrsRequest.php
│   │   └── Dosen/
│   │       └── UpdateNilaiRequest.php
│   └── Middleware/
│       └── EnsureRole.php                      # see siakad-auth-role skill
├── Services/
│   ├── AkunService.php
│   ├── MataKuliahService.php
│   ├── DosenService.php
│   ├── MahasiswaService.php
│   ├── SemesterService.php
│   ├── KelasMatkulService.php
│   ├── KrsService.php                          # SKS validation, kuota check, approval flow
│   ├── NilaiService.php                        # grade input, recalculation triggers
│   └── KhsService.php                          # derives KHS/transkrip from nilais — NOT a model, see siakad-database-conventions
└── Models/
    └── ...                                      # see siakad-database-conventions skill
```

### Why `Controllers/Admin`, `Controllers/Mahasiswa`, `Controllers/Dosen` subfolders

Some features exist for multiple roles but mean different things — KRS is filled by
mahasiswa but approved by admin, so it's **two different controllers**
(`Mahasiswa\KrsController` for self-service, `Admin\KrsApprovalController` for
approval) even though they touch the same `Krs` model. Don't try to cram both
directions into one controller with role-branching `if` statements inside — separate
controllers per role-direction keeps each one simple and keeps route middleware
grouping clean.

## Service Class Rules

1. **One Service per module**, matching the Controller it primarily serves. Services
   can call other Services if a feature legitimately spans modules (e.g. `KrsService`
   calling `KelasMatkulService::hasQuota()`), but avoid circular dependencies.
2. **Services are stateless** — no instance properties holding request data. Pass
   everything as method parameters, return values or throw exceptions.
3. **Services do NOT know about HTTP** — no `Request` objects, no `redirect()`, no
   `response()`. A Service method takes typed parameters (Models, scalars, DTOs) and
   returns typed results. This keeps Services testable and reusable from
   controllers, console commands, or queued jobs alike.
4. **Validation belongs in Form Requests, not Services** — input shape/format
   validation (`required`, `numeric`, etc.) goes in a `FormRequest` class. **Business
   rule validation** (e.g. "SKS sudah melebihi batas maksimal", "kelas sudah penuh")
   belongs in the Service, and should throw a domain exception
   (e.g. `SksMelebihiBatasException`) that the Controller catches and turns into a
   user-facing error.
5. Example shape for a Service method:
   ```php
   class KrsService
   {
       public function tambahKelasMatkul(Krs $krs, KelasMatkul $kelasMatkul): KrsDetail
       {
           if ($krs->sisaSks() < $kelasMatkul->mataKuliah->sks) {
               throw new SksMelebihiBatasException($krs, $kelasMatkul);
           }

           if (! $kelasMatkul->masihAdaKuota()) {
               throw new KelasPenuhException($kelasMatkul);
           }

           $detail = $krs->details()->create([
               'kelas_matkul_id' => $kelasMatkul->id,
               'sks_diambil' => $kelasMatkul->mataKuliah->sks,
           ]);

           $krs->recalculateTotalSks();

           return $detail;
       }
   }
   ```
   Note the Controller calling this only needs to: validate the request, resolve
   `$krs` and `$kelasMatkul`, call the service method, catch domain exceptions, return
   a response. No SKS math or kuota checking in the controller itself.

## Controller Rules

1. Controllers are **resource controllers** per module
   (`index`, `create`, `store`, `edit`, `update`, `destroy`) where the module is
   CRUD-shaped. For non-CRUD actions (e.g. "approve KRS", "set semester aktif"), add a
   dedicated method with a clear verb name (`approve`, `setActive`) — don't force
   everything into the 7 RESTful methods if it doesn't fit.
2. Inject Services via constructor, not `app()` helper or facades:
   ```php
   class KrsController extends Controller
   {
       public function __construct(private KrsService $krsService) {}
   }
   ```
3. Authorization checks (role/permission) happen in **route middleware**, not inside
   controller method bodies — see `siakad-auth-role` skill. A controller method should
   never contain `if ($user->hasRole(...))` branching; if a controller needs that,
   it's a sign the route grouping/middleware is wrong, or the feature actually needs
   two separate controllers per role (see KRS example above).

## Routes

Group routes by role + module, mirroring the controller folder structure:

```php
// routes/web.php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('akun', AkunController::class);
    Route::resource('mata-kuliah', MataKuliahController::class);
    Route::resource('dosen', DosenController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('semester', SemesterController::class);
    Route::resource('kelas-matkul', KelasMatkulController::class);
    Route::patch('krs/{krs}/approve', [KrsApprovalController::class, 'approve'])->name('krs.approve');
});

Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('krs', [KrsController::class, 'index'])->name('krs.index');
    Route::post('krs/{kelasMatkul}', [KrsController::class, 'tambah'])->name('krs.tambah');
    Route::get('khs', [KhsController::class, 'index'])->name('khs.index');
});

Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('nilai/{kelasMatkul}', [NilaiController::class, 'edit'])->name('nilai.edit');
    Route::put('nilai/{kelasMatkul}', [NilaiController::class, 'update'])->name('nilai.update');
});
```

Never define a route outside these three role-grouped blocks unless it's genuinely
public (login page, landing page if any).

## Views (Blade)

Mirror the same module structure under `resources/views/`:

```
resources/views/
├── admin/
│   ├── akun/{index,create,edit}.blade.php
│   ├── mata-kuliah/...
│   └── ...
├── mahasiswa/
│   ├── krs/index.blade.php
│   └── khs/index.blade.php
├── dosen/
│   └── nilai/edit.blade.php
└── layouts/
    ├── admin.blade.php
    ├── mahasiswa.blade.php
    └── dosen.blade.php
```

Each role gets its own layout file — don't try to make one universal layout with
conditional sidebar items based on role; it gets unmanageable fast. Follow existing
UI conventions from prior project work: minimal color palette, small border radius,
mobile-first responsive (this is consistent with how prior SIAKAD/dashboard work in
this codebase was styled).

## Before Marking a Feature "Done" — Checklist

1. Is there a Service class, or did logic leak into the Controller?
2. Does the Controller only orchestrate (validate → call service → respond)?
3. Is authorization handled by middleware/route grouping, not inline `if` role
   checks?
4. Does the route follow the role-prefix + module naming convention?
5. Are Form Requests used for input validation instead of inline `$request->validate()`
   calls, once the validation rules are non-trivial?
6. If this feature touches `Krs` or `Nilai`, did you re-check `siakad-database-conventions`
   for the business rule constants (`Krs::MAX_SKS`, `Nilai` bobot) instead of
   hardcoding numbers?
