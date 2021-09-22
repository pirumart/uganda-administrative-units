<?php

use Illuminate\Database\Seeder;

class UgandaLocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RegionTableSeeder::class);
        $this->call(DistrictTableSeeder::class);
        $this->call(CountyTableSeeder::class);
        $this->call(SubCountyTableSeeder::class);
        $this->call(ParishTableSeeder::class);
        $this->call(VillageTableSeeder::class);
    }
}
