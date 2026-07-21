<?php

namespace Pirumart\Uganda\Locale\Tests;

use Illuminate\Support\Facades\DB;

class SeedAdministrativeUnitsCommandTest extends TestCase
{
    /** @test */
    public function it_seeds_every_table_via_artisan()
    {
        $this->artisan('uganda-administrative-units:seed')->assertExitCode(0);

        $this->assertSame(14, DB::table('regions')->count());
        $this->assertSame(124, DB::table('districts')->count());
        $this->assertSame(282, DB::table('counties')->count());
        $this->assertSame(1972, DB::table('sub_counties')->count());
        $this->assertSame(9583, DB::table('parishes')->count());
        $this->assertSame(31143, DB::table('villages')->count());
    }
}
