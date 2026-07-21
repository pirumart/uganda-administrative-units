# AGENTS.md

Instructions for coding agents (Claude Code, etc.) working in this repository.

## What this is

A Laravel package, originally scaffolded from `spatie/package-skeleton-laravel`,
providing Eloquent models/migrations/seeders for Uganda's administrative
hierarchy: Region → District → County → Sub-County → Parish → Village. The
skeleton rename is finished - the main class/provider/facade/command are
`AdministrativeUnits`/`AdministrativeUnitsServiceProvider`/
`AdministrativeUnitsFacade`/`SeedAdministrativeUnitsCommand` under
`Pirumart\Uganda\Locale`.

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
- Run the suite with `composer test` (`vendor/bin/phpunit`). Tests use an
  in-memory SQLite database via `tests/TestCase.php`, which loads the
  migration stub directly - there's no need for a real database.
- After changing `composer.json` autoload rules, run `composer dump-autoload`.

## Known remaining work (not yet done)

These were identified in a full audit against `spatie/package-skeleton-laravel`
and `spatie/package-skeleton-php` but are out of scope for the fixes already
completed:

1. **Toolchain modernization.** This package still targets PHP ^7.1/^8.0 and
   Laravel 8 only, uses Psalm + legacy php-cs-fixer + PHPUnit with
   `/** @test */` annotations, and CI workflows pinned to `actions/checkout@v2`.
   Current spatie skeletons use PHP ^8.4, Laravel 11-13, PHPStan/Larastan,
   Laravel Pint, Pest, and `spatie/laravel-package-tools` in the service
   provider (`PackageServiceProvider` + fluent `configurePackage()`).
2. **`database/factories/ModelFactory.php` has no factories defined.** Not
   needed for the seed-data workflow, but would help anyone writing tests
   against these models without the full CSV datasets.
3. **`District::region()` naming collision.** `District` has both a `region`
   string column and a `region()` relation. Eloquent's attribute accessor
   wins over same-named relations for magic property access, so
   `$district->region` returns the string, not the model - always call
   `$district->region()->first()` explicitly. This is a schema-level design
   choice (natural keys throughout), not something to silently work around;
   if it's ever revisited, it needs a real decision (rename the column vs.
   rename the relation) rather than a quick patch.
4. **The `AdministrativeUnits`/`AdministrativeUnitsFacade` pair is an empty
   placeholder.** It's the renamed-but-otherwise-untouched skeleton utility
   class/facade - it holds no real behavior and this package's actual API is
   the Eloquent models. Worth a decision (remove entirely vs. give it a real
   purpose) rather than carrying it forward indefinitely just because it's
   now correctly named.

## Key files to understand the domain

- `database/migrations/create_uganda_administrative_units_table.php.stub` -
  schema for all six tables, all keyed by natural business codes rather than
  surrogate `*_id` columns.
- `src/Models/*.php` - one model per table; every `belongsTo`/`hasMany` needs
  explicit local/owner keys because of the natural-key schema (see git log
  for the fix that added these).
- `tests/ModelRelationshipsTest.php` - exercises every relation across the
  full hierarchy; the reference example for how they're expected to behave.
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
