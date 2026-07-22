<?php

use Illuminate\Support\Facades\DB;

it('seeds every table via artisan', function () {
    $this->artisan('uganda-administrative-units:seed')->assertExitCode(0);

    expect(DB::table('regions')->count())->toBe(17);
    expect(DB::table('districts')->count())->toBe(146);
    expect(DB::table('counties')->count())->toBe(321);
    expect(DB::table('sub_counties')->count())->toBe(2105);
    expect(DB::table('parishes')->count())->toBe(10322);
    expect(DB::table('villages')->count())->toBe(36839);
});
