<?php

namespace Pirumart\Uganda\Locale\Tests;

use Illuminate\Support\Facades\DB;
use Pirumart\Uganda\Locale\Database\Seeders\CountyTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\DistrictTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\ParishTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\RegionTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\SubCountyTableSeeder;
use Pirumart\Uganda\Locale\Database\Seeders\VillageTableSeeder;

class SeederTest extends TestCase
{
    /** @test */
    public function region_seeder_inserts_every_row()
    {
        (new RegionTableSeeder)->run();

        $this->assertSame(14, DB::table('regions')->count());
    }

    /** @test */
    public function district_seeder_inserts_every_row()
    {
        (new DistrictTableSeeder)->run();

        $this->assertSame(124, DB::table('districts')->count());
    }

    /** @test */
    public function county_seeder_inserts_every_row()
    {
        (new CountyTableSeeder)->run();

        $this->assertSame(282, DB::table('counties')->count());
    }

    /** @test */
    public function sub_county_seeder_inserts_every_row()
    {
        (new SubCountyTableSeeder)->run();

        $this->assertSame(1972, DB::table('sub_counties')->count());
    }

    /** @test */
    public function parish_seeder_inserts_every_row()
    {
        (new ParishTableSeeder)->run();

        $this->assertSame(9583, DB::table('parishes')->count());
    }

    /** @test */
    public function village_seeder_inserts_every_row()
    {
        (new VillageTableSeeder)->run();

        $this->assertSame(31143, DB::table('villages')->count());
    }
}
