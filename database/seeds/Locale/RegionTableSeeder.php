<?php

use DB;
use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert(
            ['region' => 'Central', 'sub_region' => 'Buganda'],
            ['region' => 'Eastern', 'sub_region' => 'Busoga'],
            ['region' => 'Eastern', 'sub_region' => 'Bukedi'],
            ['region' => 'Eastern', 'sub_region' => 'Teso'],
            ['region' => 'Eastern', 'sub_region' => 'Bugisu'],
            ['region' => 'Eastern', 'sub_region' => 'Sebei'],
            ['region' => 'Northern', 'sub_region' => 'Acholi'],
            ['region' => 'Northern', 'sub_region' => 'Lango'],
            ['region' => 'Northern', 'sub_region' => 'West Nile'],
            ['region' => 'Northern', 'sub_region' => 'Karamoja'],
            ['region' => 'Western', 'sub_region' => 'Rwenzori'],
            ['region' => 'Western', 'sub_region' => 'Bunyoro'],
            ['region' => 'Western', 'sub_region' => 'Ankole'],
            ['region' => 'Western', 'sub_region' => 'Kigezi']
        );
    }
}
