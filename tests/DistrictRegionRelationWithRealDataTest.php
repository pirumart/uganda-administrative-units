<?php

use Pirumart\Uganda\Locale\Database\Seeders\DistrictTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\RegionTableSeeder;
use Pirumart\Uganda\Locale\Models\District;

/**
 * districts.csv's region/sub_region columns used to be semantically swapped
 * relative to regions.csv's own column meanings, so this relation silently
 * returned null against real seeded data even though it worked fine against
 * hand-crafted test fixtures (see ModelRelationshipsTest, which seeds its
 * own consistent values and never exercised this mismatch).
 *
 * Only `region` is asserted, not `sub_region` - belongsTo matches on the
 * `region` column alone, which several regions.csv rows share (e.g. four
 * rows have region=Northern), so ->first() is guaranteed to return a row
 * with the right macro-region but not deterministically a specific one.
 */
it('resolves district region() against the real seeded CSV data', function () {
    (new RegionTableSeeder)->run();
    (new DistrictTableSeeder)->run();

    $district = District::where('district_name', 'APAC')->firstOrFail();

    $region = $district->region()->first();

    expect($region)->not->toBeNull()
        ->and($region->region)->toBe('Northern');
});
