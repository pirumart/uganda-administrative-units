# Changelog

All notable changes to `uganda-administrative-units` will be documented in this file.

## Unreleased

### Fixed

- Corrected PSR-4 autoload namespace mismatch in `composer.json` (`Pirumart\Skeleton\` → `Pirumart\Uganda\Locale\`), which broke autoloading of every class in `src/` and `tests/`.
- Corrected the migration filename referenced by `SkeletonServiceProvider`, which prevented `vendor:publish --tag=migrations` from finding the stub.
- Added explicit local/owner keys to every `belongsTo`/`hasMany` relation across `Region`, `District`, `County`, `SubCounty`, `Parish`, and `Village`. All of them previously relied on Eloquent's default `*_id` foreign key convention, which doesn't exist on this schema (it uses natural business keys like `district_code`), so every relation either errored or silently returned nothing.
- Renamed `Region::counties()` to `Region::districts()` - it returned `District::class`, not `County::class`.
- Fixed a data corruption bug in `ParishTableSeeder` (96 rows where a two-digit `sub_county_code` starting with 2 was mangled into invalid PHP) and removed one irrecoverably corrupted row in `VillageTableSeeder` (a bare tuple with a garbled village name).
- Removed the dead `use DB;` statement from all six table seeders (a compile-time no-op for non-namespaced names that becomes a hard error under this project's PHPUnit settings).
- Fixed the `insert($row1, $row2, ...)` multi-argument bug in every `*TableSeeder` - `Illuminate\Database\Query\Builder::insert()` takes one array parameter, so PHP silently bound only the first row and discarded the rest with no error. Every seeder previously inserted exactly 1 row instead of its full dataset (14, 124, 282, 1972, 9583, and 31143 rows respectively).
- Replaced incorrect global `unique()` constraints on `sub_county_code`, `parish_code`, and `village_code` in the migration with composite unique constraints on the full natural-key chain. Fixing the seeders exposed that these codes are local ordinals that reset per parent (e.g. `village_code` has only 61 distinct values across 31,143 real rows) rather than globally unique identifiers, so the old constraints failed against real data. Also dropped `unique()` from `county_name`, `sub_county_name`, `parish_name`, and `village_name`, which legitimately repeat across different parents.

### Changed

- Converted all six table seeders from hardcoded PHP array literals (up to 4.6MB per file) to a shared `SeedsFromCsv` trait that reads `database/data/*.csv` and inserts in chunks of 500. The data now lives in `database/data/*.csv`, is 5-6x smaller, and is reviewable/diffable in a way the original files weren't.
- Moved `database/seeds/Locale/*.php` to `database/seeds/*.php` and namespaced every seeder (plus `SeedsFromCsv`) under `Pirumart\Uganda\Locale\Database\Seeders`, with a matching PSR-4 entry in `composer.json`. Seeders are now autoloadable directly instead of requiring the files by hand.
- Finished the `spatie/package-skeleton-laravel` rename that was left half-done: `Skeleton` → `AdministrativeUnits`, `SkeletonServiceProvider` → `AdministrativeUnitsServiceProvider`, `SkeletonFacade` → `AdministrativeUnitsFacade` (accessor `administrative-units`), `config/skeleton.php` → `config/administrative-units.php`, and the published views/config paths to match. Removed `configure-skeleton.sh`, which was dead weight after hand-edits had already diverged from what it expected.

### Added

- `SeedAdministrativeUnitsCommand` (`php artisan uganda-administrative-units:seed`), replacing the placeholder `SkeletonCommand` that did nothing. Runs `UgandaLocaleSeeder` to populate all six tables.

### Tests

- Added a test reproducing the migration publish filename mismatch.
- Added a full relationship test suite (`ModelRelationshipsTest`) covering every `belongsTo`/`hasMany` across the six models, seeded through an in-memory SQLite database.
- Enabled the migration in the test environment (`TestCase::getEnvironmentSetUp`), which was previously commented out and referenced a nonexistent class name.
- Added `SeederTest`, one test per table, asserting the full expected row count is inserted.
- Added `SeedAdministrativeUnitsCommandTest`, exercising the new artisan command end to end.

### Known limitations

- `District` has both a `region` column (string) and a `region()` relation. Eloquent's attribute accessor always wins over the relation for magic property access, so `$district->region` returns the string, not the related model - call `$district->region()->first()` explicitly.
- `AdministrativeUnits`/`AdministrativeUnitsFacade` are a renamed-but-empty placeholder carried over from the skeleton template; this package's real API is the Eloquent models.
