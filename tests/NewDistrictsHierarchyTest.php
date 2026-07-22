<?php

use Illuminate\Support\Facades\DB;
use Pirumart\Uganda\Locale\Database\Seeders\CountyTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\DistrictTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\ParishTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\SubCountyTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\VillageTableSeeder;

/**
 * Regression test for the "22 districts have no county/sub-county/parish/
 * village rows" gap documented in AGENTS.md. Queries by the natural-key
 * columns directly (not the county()/sub_county()/parish() belongsTo
 * relations, which match on a single non-globally-unique code column and
 * can't be trusted to resolve the correct parent against real data).
 *
 * Madi Okollo is asserted to have counties/sub-counties but NOT parishes/
 * villages - no source data reaches that depth for it, so this documents
 * the remaining partial gap rather than hiding it.
 */
function districtCode(string $name): string
{
    return DB::table('districts')->where('district_name', $name)->value('district_code');
}

beforeEach(function () {
    (new DistrictTableSeeder)->run();
    (new CountyTableSeeder)->run();
    (new SubCountyTableSeeder)->run();
    (new ParishTableSeeder)->run();
    (new VillageTableSeeder)->run();
});

it('gives every one of the 22 previously-empty districts at least one county', function () {
    $newDistricts = [
        'ARUA CITY', 'FORT PORTAL CITY', 'GULU CITY', 'HOIMA CITY', 'JINJA CITY',
        'LIRA CITY', 'MASAKA CITY', 'MBALE CITY', 'MBARARA CITY', 'SOROTI CITY',
        'KALAKI', 'KARENGA', 'KASSANDA', 'KAZO', 'KIKUUBE', 'KITAGWENDA',
        'KWANIA', 'NABILATUK', 'OBONGI', 'RWAMPARA', 'TEREGO', 'MADI OKOLLO',
    ];

    foreach ($newDistricts as $name) {
        $districtCode = districtCode($name);

        expect($districtCode)->not->toBeNull("district {$name} should exist");
        expect(DB::table('counties')->where('district_code', $districtCode)->count())
            ->toBeGreaterThan(0, "district {$name} should have at least one county");
    }
});

it('gives the 21 fully-reconciled new districts parish and village rows', function () {
    $fullyReconciled = [
        'ARUA CITY', 'FORT PORTAL CITY', 'GULU CITY', 'HOIMA CITY', 'JINJA CITY',
        'LIRA CITY', 'MASAKA CITY', 'MBALE CITY', 'MBARARA CITY', 'SOROTI CITY',
        'KALAKI', 'KARENGA', 'KASSANDA', 'KAZO', 'KIKUUBE', 'KITAGWENDA',
        'KWANIA', 'NABILATUK', 'OBONGI', 'RWAMPARA', 'TEREGO',
    ];

    foreach ($fullyReconciled as $name) {
        $districtCode = districtCode($name);

        expect(DB::table('parishes')->where('district_code', $districtCode)->count())
            ->toBeGreaterThan(0, "district {$name} should have at least one parish");
        expect(DB::table('villages')->where('district_code', $districtCode)->count())
            ->toBeGreaterThan(0, "district {$name} should have at least one village");
    }
});

it('leaves Madi Okollo without parish or village rows, documenting the remaining gap', function () {
    $districtCode = districtCode('MADI OKOLLO');

    expect(DB::table('counties')->where('district_code', $districtCode)->count())->toBeGreaterThan(0);
    expect(DB::table('sub_counties')->where('district_code', $districtCode)->count())->toBeGreaterThan(0);
    expect(DB::table('parishes')->where('district_code', $districtCode)->count())->toBe(0);
    expect(DB::table('villages')->where('district_code', $districtCode)->count())->toBe(0);
});
