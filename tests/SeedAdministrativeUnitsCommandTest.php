<?php

use Illuminate\Support\Facades\DB;

it('seeds every table via artisan', function () {
    $this->artisan('uganda-administrative-units:seed')->assertExitCode(0);

    expect(DB::table('regions')->count())->toBe(14);
    expect(DB::table('districts')->count())->toBe(124);
    expect(DB::table('counties')->count())->toBe(282);
    expect(DB::table('sub_counties')->count())->toBe(1972);
    expect(DB::table('parishes')->count())->toBe(9583);
    expect(DB::table('villages')->count())->toBe(31143);
});
