# AGENTS.md

Instructions for coding agents (Claude Code, etc.) working in this repository.

## What this is

A Laravel package, originally scaffolded from `spatie/package-skeleton-laravel`,
providing Eloquent models/migrations/seeders for Uganda's administrative
hierarchy: Region → District → County → Sub-County → Parish → Village. The
skeleton rename is finished - the main provider/command are
`AdministrativeUnitsServiceProvider`/`SeedAdministrativeUnitsCommand` under
`Pirumart\Uganda\Locale`. This package's real API is the Eloquent models
under `Pirumart\Uganda\Locale\Models`; there is no top-level
`AdministrativeUnits` class or facade (removed - it was an empty skeleton
leftover with no behavior).

## Commit conventions

- Prefix commit subjects with `(feat)`, `(fix)`, `(chore)`, or `(tests)` -
  **no colon** after the prefix. e.g. `(fix) correct migration filename`,
  not `(fix): correct migration filename`.
- Do not add AI co-authorship / attribution lines to commit messages.
- Separate test commits from implementation commits where practical (a
  `(tests)` commit adding a failing test, followed by a `(fix)`/`(feat)`
  commit making it pass) - this repo follows TDD.

## Development workflow

- **TDD is required.** Write a failing test first, run it and confirm it
  fails for the expected reason, then write the minimal code to pass. See
  `superpowers:test-driven-development` if using Claude Code with the
  Superpowers plugin.
- Run the suite with `composer test` (`vendor/bin/pest`). Tests use an
  in-memory SQLite database via `tests/TestCase.php`, which loads the
  migration stub directly - there's no need for a real database. Tests are
  written in Pest's functional `it()`/`expect()` style, not PHPUnit classes -
  `tests/TestCase.php` stays a class (bound via `tests/Pest.php`'s `uses()`
  call) but individual test files should not be.
- `composer analyse` runs PHPStan/Larastan (level 5, `src/` only).
  `composer format` runs Laravel Pint.
- After changing `composer.json` autoload rules, run `composer dump-autoload`.
- Requires PHP ^8.2 and Laravel 12 (`illuminate/contracts` ^12.0) - Laravel
  10.x/11.x are not supported because they carry unpatched security
  advisories as of this writing, and Larastan/Pest's Laravel plugin
  compatibility windows don't bridge cleanly across majors either way. If revisiting this floor, re-run `composer update` and check `composer audit` before
  committing to a wider range - don't assume the constraint math resolves
  just because the version ranges look compatible on paper.

## Resolved decisions worth knowing

- **`District::region()` naming collision is intentionally left as-is.**
  `District` has both a `region` string column and a `region()` relation of
  the same name. Eloquent's attribute accessor always wins over same-named
  relations for magic property access, so `$district->region` returns the
  string column, not the model - callers must call
  `$district->region()->first()` explicitly for the relation. This was a
  deliberate choice to avoid a breaking rename (the `region` column name is
  used across the migration, seeders, and CSV data) rather than an oversight
  - don't "fix" it without checking in first, since a future agent might read
  the mismatched names and assume it's an unfixed bug. Note this is
  independent of the region/sub_region *value* swap bug fixed below - that
  was about `districts.csv` holding the wrong data in each column, not about
  the naming collision itself, which is unchanged.
- **No top-level `AdministrativeUnits` class/facade.** Removed rather than
  given a purpose - this package's API is the Eloquent models, not a
  container-bound utility class. Don't re-add one speculatively.
- **`districts.csv`/`regions.csv` were reconciled against an authoritative
  boundary source** (see git log for "reconcile district/region data"). If
  you find another region/sub_region-swap-shaped bug or stale district list
  elsewhere, check whether it's already been fixed here before re-deriving
  from scratch.

## Known remaining work (not yet done)

- **Madi Okollo has no parish/village data.** 21 of the 22 districts added in
  the district/region reconciliation now have full county-through-village
  data (see CHANGELOG "Unreleased"). Madi Okollo is the one exception - it
  has county/sub-county rows but no parish/village rows, because no
  available source reaches that depth for it. Populating those would need a
  different source (e.g. a parish- or village-level shapefile covering that
  district).

## Key files to understand the domain

- `database/migrations/create_uganda_administrative_units_table.php.stub` -
  schema for all six tables, all keyed by natural business codes rather than
  surrogate `*_id` columns.
- `src/Models/*.php` - one model per table; every `belongsTo`/`hasMany` needs
  explicit local/owner keys because of the natural-key schema (see git log
  for the fix that added these).
- `tests/ModelRelationshipsTest.php` - exercises every relation across the
  full hierarchy; the reference example for how they're expected to behave.
  Also where `seedFullHierarchy()`, a plain top-level function other test
  files could reuse if they need the same seeded hierarchy, is defined.
- `database/seeds/*TableSeeder.php` + `database/seeds/Concerns/SeedsFromCsv.php` -
  namespaced under `Pirumart\Uganda\Locale\Database\Seeders` and autoloaded
  via composer.json's PSR-4 map. Each seeder reads its table's
  `database/data/*.csv` and inserts in chunks. If you need to regenerate a
  CSV from a legacy PHP-array seeder again, don't hand-parse a multi-megabyte
  file - use a sandboxed extraction script that stubs the `DB` facade to
  capture rows via a variadic parameter (safe even against the old
  `insert($row1, $row2, ...)` multi-argument bug). See git log for the
  approach used to convert these.
- `src/Commands/SeedAdministrativeUnitsCommand.php` - the
  `uganda-administrative-units:seed` artisan command, registered in
  `AdministrativeUnitsServiceProvider`; runs `UgandaLocaleSeeder`.
- `tests/SeederTest.php` - one test per table asserting the full CSV row
  count actually gets inserted; the regression test for the multi-argument
  `insert()` bug.
- `tests/SeedAdministrativeUnitsCommandTest.php` - exercises the artisan
  command end to end.
- `database/factories/*Factory.php` - one factory per model, generating fake
  codes/names via faker rather than depending on the CSV datasets. Naming
  convention (`{Model}Factory`) is configured in
  `TestCase::guessFactoryNamesUsing`, so `Model::factory()` resolves
  correctly on all six models (each uses the `HasFactory` trait).
- `tests/ModelFactoriesTest.php` - one test per model asserting
  `::factory()->create()` persists successfully.
- `tests/DistrictRegionRelationWithRealDataTest.php` - regression test for
  the region/sub_region swap fix; seeds the real CSVs (not a hand-crafted
  fixture) to catch data-shape bugs the fixture-based
  `ModelRelationshipsTest` can't see.
- `tests/NewDistrictsHierarchyTest.php` - regression test for the
  county/sub-county/parish/village gap-fill covering 21 of the 22 districts
  added in the district/region reconciliation; also documents that Madi
  Okollo (the 22nd) still has no parish/village rows. Queries tables
  directly by natural-key columns rather than through the
  county()/sub_county()/parish() belongsTo relations, which match on a
  single non-globally-unique code column (`sub_county_code`/`parish_code`
  are local ordinals that repeat across different parents) and can't be
  trusted to resolve the correct parent against real data.
