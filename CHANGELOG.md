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
- Fixed `districts.csv`'s `region`/`sub_region` columns, which held swapped values relative to their own names and to `regions.csv` (e.g. APAC's `region` held `"Lango"` and `sub_region` held `"Northern"` - backwards). This meant `District::region()->first()` returned `null` against every real seeded district, even though it worked in `ModelRelationshipsTest`'s hand-crafted fixture (which seeds its own internally-consistent values and never exercised the mismatch). Re-derived both columns for all 146 districts from an authoritative boundary source (see "Changed" below).

### Changed

- Converted all six table seeders from hardcoded PHP array literals (up to 4.6MB per file) to a shared `SeedsFromCsv` trait that reads `database/data/*.csv` and inserts in chunks of 500. The data now lives in `database/data/*.csv`, is 5-6x smaller, and is reviewable/diffable in a way the original files weren't.
- Moved `database/seeds/Locale/*.php` to `database/seeds/*.php` and namespaced every seeder (plus `SeedsFromCsv`) under `Pirumart\Uganda\Locale\Database\Seeders`, with a matching PSR-4 entry in `composer.json`. Seeders are now autoloadable directly instead of requiring the files by hand.
- Finished the `spatie/package-skeleton-laravel` rename that was left half-done: `Skeleton` → `AdministrativeUnits`, `SkeletonServiceProvider` → `AdministrativeUnitsServiceProvider`, `SkeletonFacade` → `AdministrativeUnitsFacade` (accessor `administrative-units`), `config/skeleton.php` → `config/administrative-units.php`, and the published views/config paths to match. Removed `configure-skeleton.sh`, which was dead weight after hand-edits had already diverged from what it expected.
- Modernized the toolchain to match the current `spatie/package-skeleton-laravel` conventions:
  - Bumped to PHP ^8.2 and `illuminate/contracts` ^12.0 (Laravel 12 only - Laravel 10.x/11.x currently carry unpatched security advisories, and Larastan/Pest's Laravel-plugin compatibility windows don't bridge the gap either way).
  - Rewrote `AdministrativeUnitsServiceProvider` on `spatie/laravel-package-tools` (`PackageServiceProvider` + fluent `configurePackage()`), dropping the manual `publishes()`/`mergeConfigFrom()`/`migrationFileExists()` boilerplate. The migration publish tag changed from `migrations` to `administrative-units-migrations` (package-tools' naming convention).
  - Swapped `vimeo/psalm` for `larastan/larastan` (added `phpstan.neon.dist`, level 5, passes clean) and `friendsofphp/php-cs-fixer` for `laravel/pint` (removed `.php_cs.dist`; ran `vendor/bin/pint` across the codebase).
  - Migrated the test suite from PHPUnit class-based `/** @test */` annotations to Pest's functional `it()`/`expect()` style; added `tests/Pest.php`; removed the placeholder `ExampleTest`.
  - Modernized `phpunit.xml.dist` to the current schema (dropped attributes removed since PHPUnit 10).
  - Updated GitHub Actions: `run-tests.yml` now tests PHP 8.2/8.3/8.4 × Laravel 12 with `actions/checkout@v4` and runs Pest; replaced `psalm.yml` with `phpstan.yml`; replaced `php-cs-fixer.yml` with `fix-php-code-style-issues.yml` (Pint).
- Reconciled `database/data/districts.csv` and `regions.csv` against an authoritative district-boundary GeoJSON export, growing 124 → 146 districts and 14 → 17 regions (14 sub-regions unchanged, 3 added):
  - Appended the 22 districts/cities the old data predates: 10 new cities from Uganda's 2020 municipal-to-city reform (Arua, Fort Portal, Gulu, Hoima, Jinja, Lira, Masaka, Mbale, Mbarara, Soroti) and 12 newer districts (Kalaki, Karenga, Kassanda, Kazo, Kikuube, Kitagwenda, Kwania, Madi Okollo, Nabilatuk, Obongi, Rwampara, Terego), with new codes 125–146 (alphabetical, for reproducibility). All 124 existing `district_code` values are unchanged, since `counties.csv`/`sub_counties.csv`/`parishes.csv`/`villages.csv` reference them.
  - Added 3 new sub-regions to `regions.csv`: Kampala (Central), Madi (Northern, split from West Nile), Tooro (Western, split from Rwenzori) - chosen from the source's `New_SubReg` field specifically because it's compatible with the existing 14 sub-region names, unlike the source's alternate `Sub_Region` field (which merges Bugisu+Sebei into "Elgon" and splits Buganda into North/South).

### Added

- `SeedAdministrativeUnitsCommand` (`php artisan uganda-administrative-units:seed`), replacing the placeholder `SkeletonCommand` that did nothing. Runs `UgandaLocaleSeeder` to populate all six tables.
- Factories for all six models (`RegionFactory`, `DistrictFactory`, `CountyFactory`, `SubCountyFactory`, `ParishFactory`, `VillageFactory`), added `HasFactory` to each model, and replaced the commented-out `ModelFactory.php` placeholder. Lets tests create a unit or two via faker without seeding the full CSV datasets.

### Tests

- Added a test reproducing the migration publish filename mismatch.
- Added a full relationship test suite (`ModelRelationshipsTest`) covering every `belongsTo`/`hasMany` across the six models, seeded through an in-memory SQLite database.
- Enabled the migration in the test environment (`TestCase::getEnvironmentSetUp`), which was previously commented out and referenced a nonexistent class name.
- Added `SeederTest`, one test per table, asserting the full expected row count is inserted.
- Added `SeedAdministrativeUnitsCommandTest`, exercising the new artisan command end to end.
- Added `ModelFactoriesTest`, one test per model, asserting `::factory()->create()` persists successfully.
- Added `DistrictRegionRelationWithRealDataTest`, seeding the real CSVs (not a hand-crafted fixture) to catch data-shape bugs the fixture-based `ModelRelationshipsTest` can't see - the regression test for the region/sub_region swap fix.

### Removed

- `AdministrativeUnits`/`AdministrativeUnitsFacade` (and the corresponding `composer.json` `extra.laravel.aliases` entry) - a renamed-but-empty skeleton placeholder with no real behavior. This package's API is the Eloquent models; the service provider and command are unaffected.

### Known limitations

- `District` has both a `region` column (string) and a `region()` relation. Eloquent's attribute accessor always wins over the relation for magic property access, so `$district->region` returns the string, not the related model - call `$district->region()->first()` explicitly. This is a deliberate choice (avoids a breaking rename of a column used across the migration/seeders/CSV data), not an unfixed bug.
- County/sub-county/parish/village data has not been reconciled to current administrative boundaries - only district/region were (the available boundary source is district-level only). The 22 newly added districts have no county/sub-county/parish/village rows.
