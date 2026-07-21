<?php

namespace Pirumart\Uganda\Locale\Tests;

use Illuminate\Support\Facades\DB;

class SeederTest extends TestCase
{
    protected function runSeeder(string $class): void
    {
        require_once __DIR__ . "/../database/seeds/Locale/{$class}.php";
        (new $class())->run();
    }

    /** @test */
    public function region_seeder_inserts_every_row()
    {
        $this->runSeeder('RegionTableSeeder');

        $this->assertSame(14, DB::table('regions')->count());
    }

    /** @test */
    public function district_seeder_inserts_every_row()
    {
        $this->runSeeder('DistrictTableSeeder');

        $this->assertSame(124, DB::table('districts')->count());
    }

    /** @test */
    public function county_seeder_inserts_every_row()
    {
        $this->runSeeder('CountyTableSeeder');

        $this->assertSame(282, DB::table('counties')->count());
    }

    /** @test */
    public function sub_county_seeder_inserts_every_row()
    {
        $this->runSeeder('SubCountyTableSeeder');

        $this->assertSame(1972, DB::table('sub_counties')->count());
    }

    /** @test */
    public function parish_seeder_inserts_every_row()
    {
        $this->runSeeder('ParishTableSeeder');

        $this->assertSame(9583, DB::table('parishes')->count());
    }

    /** @test */
    public function village_seeder_inserts_every_row()
    {
        $this->runSeeder('VillageTableSeeder');

        $this->assertSame(31143, DB::table('villages')->count());
    }
}
