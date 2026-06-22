---
name: siakad-database-conventions
description: "Use this skill whenever working on database schema, migrations, or Eloquent models in the SIAKAD mini project — creating new migrations, adding/modifying tables, defining model relationships, or adding business logic to a model (e.g. nilai calculation, SKS validation). Triggers include: 'buat migration', 'tambah tabel', 'buat model', 'relasi ke', 'tambah kolom', or any request touching database/models/eloquent relationships in this project. Also use when reviewing or refactoring existing migrations/models to check they follow project conventions. Do NOT use for frontend/Blade work, route definitions, or controller logic unrelated to schema — use siakad-modular-structure for that instead."
---

# SIAKAD Mini — Database & Model Conventions

## Overview

This project has an established database structure already designed and migrated.
**Do not invent a new schema, rename existing tables/columns, or restructure
relationships without being explicitly asked.** If a new feature seems to need a
schema change, propose it first instead of just creating it — the existing structure
was deliberately designed to avoid duplication and to keep data integrity at the
database level (not just application-level validation).

## The Existing Schema — Do Not Re-derive From Scratch

These tables already exist. Read the actual migration files in
`database/migrations/` before assuming a column name — never guess.

| Table | Purpose | Key columns |
|---|---|---|
| `users` | Auth for ALL roles (admin/dosen/mahasiswa) | `identifier` (NIM/NIDN/username), `password`, `is_active` |
| `mahasiswas` | Mahasiswa profile, 1:1 to `users` | `user_id`, `nim`, `angkatan`, `program_studi`, `status` |
| `dosens` | Dosen profile, 1:1 to `users` | `user_id`, `nidn`, `nama_lengkap` |
| `semesters` | Semester management | `is_active`, `krs_mulai`, `krs_selesai` |
| `mata_kuliahs` | Matkul master data | `kode`, `nama`, `sks`, `semester_ke` |
| `kelas_matkuls` | **KEY TABLE** — one row = one class offering (matkul + dosen + semester + kelas) | `mata_kuliah_id`, `dosen_id`, `semester_id`, `nama_kelas`, `kapasitas` |
| `krs` | KRS header, one per mahasiswa per semester | `mahasiswa_id`, `semester_id`, `total_sks`, `status` |
| `krs_details` | KRS line items, pointing to `kelas_matkuls` | `krs_id`, `kelas_matkul_id`, `sks_diambil` (snapshot) |
| `nilais` | Grades per mahasiswa per `kelas_matkul` | `nilai_tugas`, `nilai_uts`, `nilai_uas`, `nilai_akhir` (auto), `nilai_huruf` (auto) |

Role/permission tables (`roles`, `permissions`, `model_has_roles`, etc.) come from
Spatie Laravel Permission — see the `siakad-auth-role` skill for anything
touching auth/roles.

## Non-Negotiable Structural Rules

### 1. Mahasiswa never takes a `mata_kuliah` directly — always via `kelas_matkul`

`kelas_matkuls` is the pivot that carries dosen + semester + class section. A single
matkul can have many `kelas_matkul` rows (different dosen/sections/semesters).

- ❌ WRONG: `krs_details.mata_kuliah_id`, `nilais.mata_kuliah_id`
- ✅ CORRECT: `krs_details.kelas_matkul_id`, `nilais.kelas_matkul_id`

If you ever find yourself wanting to add a `mata_kuliah_id` foreign key to a table
that isn't `kelas_matkuls`, stop — you're bypassing the class/dosen/semester context
and that's a sign the join should go through `kelas_matkul` instead.

### 2. KHS is NEVER a table

KHS (rekap nilai per semester) is a **derived view**, computed from `nilais` joined
through `krs_details` → `krs` filtered by `semester_id`. Do not create a `khs` table
or a `khs` migration. Implement it as a method/service (e.g.
`MahasiswaService::getKhs(Mahasiswa $mhs, Semester $semester)`), not a stored table —
storing it would duplicate data that's already in `nilais` and risk going out of sync.

Same logic applies to transkrip (cumulative KHS across all semesters) — derive it,
don't store it.

### 3. Snapshot SKS at KRS time, never re-derive it later

`krs_details.sks_diambil` is a deliberate snapshot of `mata_kuliah.sks` taken at the
moment the KRS was submitted. This is intentional — if a matkul's SKS value is edited
later, historical KRS records must NOT change retroactively. Never replace this with
a live join to `mata_kuliahs.sks` for historical records.

### 4. Nilai calculation logic lives in the Model, never in a controller/migration

`nilai_akhir` and `nilai_huruf` are **always** computed automatically via the
`Nilai` model's `booted()` `saving` hook — never set manually, never computed in a
controller, never duplicated in a service. The fixed weight is:

```
nilai_akhir = (nilai_tugas × 0.30) + (nilai_uts × 0.30) + (nilai_uas × 0.40)
```

If asked to change the weighting scheme, the single source of truth to edit is
`App\Models\Nilai::BOBOT_TUGAS` / `BOBOT_UTS` / `BOBOT_UAS` constants — never hardcode
weights anywhere else in the codebase.

### 5. Business rule constants live on the model, not scattered as magic numbers

- Max SKS per KRS → `App\Models\Krs::MAX_SKS` (currently 24, fixed for all mahasiswa)
- Grade conversion scale → `App\Models\Nilai::KONVERSI_HURUF`

When writing validation logic anywhere (controller, service, form request), reference
these constants — never hardcode `24` or grade boundary numbers inline.

## Naming Conventions to Follow

- **Tables**: snake_case, plural (`mahasiswas`, `kelas_matkuls`, `nilais`) — even when
  the plural is grammatically odd in Indonesian (e.g. `nilais` not `nilai`), for
  consistency with Eloquent's default pluralization.
- **Foreign keys**: `{singular_table}_id` (e.g. `mahasiswa_id`, `kelas_matkul_id`,
  `semester_id`). Always pair with `->constrained('table_name')` explicitly — don't
  rely on Laravel's guessed convention if the table name doesn't perfectly match.
- **Model class names**: PascalCase singular, matching table semantics, NOT always a
  literal singularization of the table name. Note these deliberate exceptions:
  - Table `mata_kuliahs` → Model `MataKuliah` (not `Mataculiah`/`MataKuliahs`)
  - Table `kelas_matkuls` → Model `KelasMatkul`
  - Table `krs` → Model `Krs` (irregular, no trailing 's' on the table itself)
  - Table `nilais` → Model `Nilai`
  - Always set `protected $table` explicitly on models where the guessed table name
    wouldn't match (see existing models for the pattern).
- **Migration filenames**: must sort in dependency order — a table cannot be created
  before a table it has a foreign key to. Check existing migration timestamps before
  adding a new one; insert your timestamp to preserve correct ordering (e.g. a new
  table referencing `kelas_matkuls` must have a migration timestamp AFTER
  `2024_01_01_000006_create_kelas_matkuls_table.php`).

## Workflow for Adding a New Migration

1. Read existing related migrations first (`view database/migrations/`) — never
   assume column names from memory.
2. Determine dependency order — does the new table reference an existing table? Place
   the migration timestamp accordingly.
3. Add `$table->comment()` or inline PHP comments explaining *why* a column exists if
   its purpose isn't obvious from the name alone (this codebase favors documented
   migrations — see existing files for the tone/style).
4. Add a unique constraint at the **database level** wherever the business rule
   demands uniqueness (e.g. one KRS per mahasiswa per semester) — do not rely on
   application-level validation alone for data integrity.
5. After creating the migration, create/update the corresponding Model with relations
   — a migration without a matching Eloquent relationship is incomplete work.

## Workflow for Adding/Modifying a Model

1. Always define relationship return types explicitly (`BelongsTo`, `HasMany`,
   `HasOne`) — match the style already used in existing models.
2. Add `protected $fillable` listing every mass-assignable column explicitly — never
   use `protected $guarded = []`.
3. Use `protected function casts(): array` (method syntax, Laravel 11+ style) — not
   the old `protected $casts = []` property style — for consistency with existing
   models.
4. If the model needs computed/derived values (like `Nilai`), put that logic in the
   model itself as a method or accessor — not in a controller. Controllers call model
   methods, they don't replicate model logic.
5. Before considering the work done, check: does this model need updating in the
   README's "Struktur Database" / "Diagram relasi" section? If the schema changed,
   the README documentation must be updated in the same task — stale docs are worse
   than no docs.
