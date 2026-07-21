<?php

use Illuminate\Database\Seeder;

require_once __DIR__ . '/Concerns/SeedsFromCsv.php';

class DistrictTableSeeder extends Seeder
{
    use SeedsFromCsv;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedFromCsv('districts', __DIR__ . '/../../data/districts.csv');
    }
}
