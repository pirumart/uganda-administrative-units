# Changelog

All notable changes to `uganda-administrative-units` will be documented in this file.

## Unreleased

### Fixed

- Corrected PSR-4 autoload namespace mismatch in `composer.json` (`Pirumart\Skeleton\` → `Pirumart\Uganda\Locale\`), which broke autoloading of every class in `src/` and `tests/`.
- Corrected the migration filename referenced by `SkeletonServiceProvider`, which prevented `vendor:publish --tag=migrations` from finding the stub.

### Tests

- Added a test reproducing the migration publish filename mismatch.

## 1.0.0 - 202X-XX-XX

- initial release
