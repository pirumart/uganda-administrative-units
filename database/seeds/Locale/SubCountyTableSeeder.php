<?php

use Illuminate\Database\Seeder;

require_once __DIR__ . '/Concerns/SeedsFromCsv.php';

class SubCountyTableSeeder extends Seeder
{
    use SeedsFromCsv;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedFromCsv('sub_counties', __DIR__ . '/../../data/sub_counties.csv');
    }
}
