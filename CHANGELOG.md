# Changelog

All notable changes to `uganda-administrative-units` will be documented in this file.

## Unreleased

### Fixed

- Corrected PSR-4 autoload namespace mismatch in `composer.json` (`Pirumart\Skeleton\` → `Pirumart\Uganda\Locale\`), which broke autoloading of every class in `src/` and `tests/`.
- Corrected the migration filename referenced by `SkeletonServiceProvider`, which prevented `vendor:publish --tag=migrations` from finding the stub.
- Added explicit local/owner keys to every `belongsTo`/`hasMany` relation across `Region`, `District`, `County`, `SubCounty`, `Parish`, and `Village`. All of them previously relied on Eloquent's default `*_id` foreign key convention, which doesn't exist on this schema (it uses natural business keys like `district_code`), so every relation either errored or silently returned nothing.
- Renamed `Region::counties()` to `Region::districts()` - it returned `District::class`, not `County::class`.

### Tests

- Added a test reproducing the migration publish filename mismatch.
- Added a full relationship test suite (`ModelRelationshipsTest`) covering every `belongsTo`/`hasMany` across the six models, seeded through an in-memory SQLite database.
- Enabled the migration in the test environment (`TestCase::getEnvironmentSetUp`), which was previously commented out and referenced a nonexistent class name.

### Known limitations

- `District` has both a `region` column (string) and a `region()` relation. Eloquent's attribute accessor always wins over the relation for magic property access, so `$district->region` returns the string, not the related model - call `$district->region()->first()` explicitly.

## 1.0.0 - 202X-XX-XX

- initial release
