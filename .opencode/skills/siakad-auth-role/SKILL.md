---
name: siakad-auth-role
description: "Use this skill whenever implementing or modifying login/logout logic, authentication guards, Spatie role/permission assignment, or role-based access control (middleware, route protection, 'who can access what') in the SIAKAD mini project. Triggers include: 'buat login', 'buat logout', 'cek role', 'middleware role', 'assign role', 'spatie permission', 'siapa yang boleh akses', or any request involving distinguishing admin/dosen/mahasiswa access. Do NOT use this skill for general CRUD features unrelated to auth — use siakad-modular-structure instead. Do NOT use for schema changes to users/roles tables — use siakad-database-conventions first, then come back to this skill for the application logic."
---

# SIAKAD Mini — Auth & Role Convention

## Overview

This project uses **custom manual authentication** — NOT Laravel Breeze, NOT
Fortify, NOT Jetstream. Do not scaffold or suggest installing any of those packages.
Login is identifier-based (NIM for mahasiswa, NIDN for dosen, username for admin)
against a single `users` table, with role assignment handled by
**Spatie Laravel Permission** (`spatie/laravel-permission`).

If asked to "add login" or "fix login," always check first whether custom auth
logic already exists before scaffolding something new — this project deliberately
does not use Laravel's default auth scaffolding.

## Core Auth Model

- **One `users` table for all roles.** There is no separate `admins`/`dosens_auth`
  table for credentials — `dosens` and `mahasiswas` tables hold *profile* data only,
  linked via `user_id`. Credentials (`identifier`, `password`) live exclusively on
  `users`.
- **`identifier` column is role-agnostic.** It holds a NIM, a NIDN, or a username
  depending on what role the user has. The login form does NOT ask "are you
  admin/dosen/mahasiswa" — it's a single field, single password field, and the system
  resolves identity purely by matching `identifier` in `users`.
- **Role comes from Spatie, never from a column on `users`.** Do not add a `role`
  enum/string column to `users` — that would create two sources of truth. Always use
  `$user->hasRole('mahasiswa')`, `$user->assignRole('dosen')`, etc.

## Login Flow — How It Must Work

1. Single login form: `identifier` + `password`. No role selector dropdown.
2. Controller (`Auth\LoginController` or similar) looks up
   `User::where('identifier', $request->identifier)->first()`.
3. Verify password with `Hash::check()`, verify `is_active` is true (reject inactive
   accounts with a clear message, not a generic "invalid credentials").
4. On success, log in via `Auth::login($user)`, then **redirect based on role**:
   ```php
   if ($user->isAdmin())      return redirect()->route('admin.dashboard');
   if ($user->isDosen())      return redirect()->route('dosen.dashboard');
   if ($user->isMahasiswa())  return redirect()->route('mahasiswa.dashboard');
   ```
   Use the `isAdmin()`/`isDosen()`/`isMahasiswa()` helper methods already defined on
   the `User` model — don't re-write `hasRole('admin')` inline everywhere; if a new
   role-check helper is needed, add it to the `User` model alongside the existing
   ones, don't scatter raw `hasRole()` calls through controllers.
5. **Do not assume a user can only have one role.** Spatie supports multiple roles
   per user; the redirect logic above checks in priority order
   (admin → dosen → mahasiswa) specifically because admin is the most privileged. If
   a user somehow has multiple roles, admin redirect wins. Don't reorder this priority
   without being asked.
6. Logout is a simple `Auth::logout()` + session invalidation + redirect to login —
   no per-role logout variations needed.

## Authorization — Route & Middleware Rules

1. **Role checks happen at the route/middleware level**, never inline inside
   controller methods as `if ($user->hasRole(...)) { ... } else { abort(403); }`. See
   `siakad-modular-structure` skill for how routes are grouped by role prefix.
2. Use Spatie's built-in `role:` middleware alias (already registered by the package)
   in route groups:
   ```php
   Route::middleware(['auth', 'role:admin'])->group(function () { ... });
   ```
3. If a feature needs finer-grained permission (not just role) — e.g. "only the dosen
   assigned to this specific `kelas_matkul` can input its grades" — that is **not** a
   Spatie permission check, it's an **ownership check**, and belongs in the Service
   layer or a Form Request's `authorize()` method, e.g.:
   ```php
   public function authorize(): bool
   {
       return $this->route('kelasMatkul')->dosen_id === auth()->user()->dosen->id;
   }
   ```
   Don't try to model "this dosen owns this specific kelas" as a Spatie permission —
   Spatie permissions are for role/capability checks, not row-level ownership.
4. Never expose a route without an explicit auth + role middleware group. If a route
   is genuinely public (e.g. landing/login page itself), it must be outside all
   `auth` middleware groups, not given a "guest-but-still-checked" role.

## Spatie Setup — What Already Exists, What Not To Redo

- Roles `admin`, `dosen`, `mahasiswa` are already seeded via `RoleSeeder`. Don't
  recreate this seeder logic elsewhere — if new roles are needed, extend
  `RoleSeeder`, don't create a second seeder that also touches roles.
- `User` model already has `use HasRoles;` from Spatie and `protected $guard_name =
  'web';`. Don't add a second guard unless explicitly asked — this project
  intentionally uses one guard for all roles, not separate guards per role type.
- Granular permissions (beyond role) have **not** been built yet — currently access
  is role-only. If a task requires permission-level granularity (e.g. "some admins
  can approve KRS, others can't"), flag this as a scope decision to confirm before
  building it — don't silently introduce a permissions matrix.

## Registering New Users (Admin Creates Accounts)

There is no public self-registration page — mahasiswa/dosen accounts are created by
admin (this is standard for institutional SIAKAD systems, not a self-signup app).
When building the "Akun" module (see `siakad-modular-structure`):

1. Creating a mahasiswa account = create a `User` row (with NIM as `identifier`) AND
   a `Mahasiswa` profile row in the same transaction — never create one without the
   other. Wrap in `DB::transaction()`.
2. Same pattern for dosen: `User` (NIDN as `identifier`) + `Dosen` profile row,
   atomically.
3. Immediately after creating the `User`, call `$user->assignRole(...)` — a `User`
   row without an assigned role is an invalid/incomplete state in this system, even
   though the database won't stop you from creating one.
4. Default/temporary passwords should be hashed with `Hash::make()` before storage —
   never store plaintext, even temporarily, even in a seeder for "testing purposes."

## Common Mistakes to Avoid

- ❌ Adding `email` as the login field "because that's the Laravel default" — this
  project explicitly uses `identifier` (NIM/NIDN/username), not email, for login.
  `email` columns that exist on `mahasiswas`/`dosens` are contact info, not
  credentials.
- ❌ Installing Breeze/Fortify/Jetstream "to save time" — this project has
  intentionally custom auth; scaffolding one of these packages will conflict with
  the existing `users` table structure and create duplicate/competing auth flows.
- ❌ Adding a `role` string/enum column to `users` — role is Spatie-managed only.
- ❌ Putting role-check `if` statements inside controller method bodies instead of
  route middleware.
- ❌ Conflating "role" with "ownership" — a dosen's role grants access to *a* nilai
  input screen; whether they can edit *this specific* kelas_matkul's grades is an
  ownership check, not a role/permission check.
