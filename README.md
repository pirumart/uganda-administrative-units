# Uganda Administrative Units

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pirumart/uganda-administrative-units.svg?style=flat-square)](https://packagist.org/packages/pirumart/uganda-administrative-units)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pirumart/uganda-administrative-units/run-tests.yml?branch=main&label=tests)](https://github.com/pirumart/uganda-administrative-units/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pirumart/uganda-administrative-units.svg?style=flat-square)](https://packagist.org/packages/pirumart/uganda-administrative-units)

A Laravel package providing Eloquent models and migrations for Uganda's administrative
units hierarchy: Region → District → County → Sub-County → Parish → Village.

## Installation

You can install the package via composer:

```bash
composer require pirumart/uganda-administrative-units
```

Publish and run the migration with:

```bash
php artisan vendor:publish --provider="Pirumart\Uganda\Locale\AdministrativeUnitsServiceProvider" --tag="migrations"
php artisan migrate
```

This creates the `regions`, `districts`, `counties`, `sub_counties`, `parishes` and
`villages` tables. All of them use natural business keys (e.g. `district_code`,
`county_code`) rather than surrogate foreign keys.

## Usage

Each model exposes relations to its parent and child units in the hierarchy:

```php
use Pirumart\Uganda\Locale\Models\District;

$district = District::where('district_code', 'D01')->first();

$district->region()->first(); // parent Region
$district->counties;          // child Counties
$district->sub_counties;      // child SubCounties
$district->parishes;          // child Parishes
$district->villages;          // child Villages
```

```php
use Pirumart\Uganda\Locale\Models\Village;

$village = Village::where('village_code', 'V01')->first();

$village->district;    // parent District
$village->county;      // parent County
$village->sub_county;  // parent SubCounty
$village->parish;      // parent Parish
```

### Known limitation: `District::region()`

`District` has both a `region` column (the region name, stored as a string) and a
`region()` relation method of the same name. Eloquent's attribute accessor always
takes priority over a relation of the same name for magic property access, so
`$district->region` returns the string column - **not** the related `Region` model.
Call the relation explicitly instead:

```php
$district->region()->first();
```

### Seed data

`database/seeds/` contains a seeder per table (`RegionTableSeeder`,
`DistrictTableSeeder`, etc.), backed by the real Uganda administrative data in
`database/data/*.csv` (14 regions, 124 districts, 282 counties, 1972
sub-counties, 9583 parishes, 31143 villages). `UgandaLocaleSeeder` runs all six
in hierarchy order.

The easiest way to populate the tables is the console command:

```bash
php artisan uganda-administrative-units:seed
```

Or run `UgandaLocaleSeeder` directly - it's autoloaded under
`Pirumart\Uganda\Locale\Database\Seeders`:

```php
use Pirumart\Uganda\Locale\Database\Seeders\UgandaLocaleSeeder;

(new UgandaLocaleSeeder())->run();
```

`database/factories/ModelFactory.php` has no factories defined yet.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details. If you're a coding
agent working on this repository, also read [AGENTS.md](AGENTS.md).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
