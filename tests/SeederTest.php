<?php

use Illuminate\Support\Facades\DB;
use Pirumart\Uganda\Locale\Database\Seeders\CountyTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\DistrictTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\ParishTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\RegionTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\SubCountyTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\VillageTableSeeder;

it('inserts every row via the region seeder', function () {
    (new RegionTableSeeder)->run();

    expect(DB::table('regions')->count())->toBe(14);
});

it('inserts every row via the district seeder', function () {
    (new DistrictTableSeeder)->run();

    expect(DB::table('districts')->count())->toBe(124);
});

it('inserts every row via the county seeder', function () {
    (new CountyTableSeeder)->run();

    expect(DB::table('counties')->count())->toBe(282);
});

it('inserts every row via the sub county seeder', function () {
    (new SubCountyTableSeeder)->run();

    expect(DB::table('sub_counties')->count())->toBe(1972);
});

it('inserts every row via the parish seeder', function () {
    (new ParishTableSeeder)->run();

    expect(DB::table('parishes')->count())->toBe(9583);
});

it('inserts every row via the village seeder', function () {
    (new VillageTableSeeder)->run();

    expect(DB::table('villages')->count())->toBe(31143);
});
