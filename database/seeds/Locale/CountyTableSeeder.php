<?php

use Illuminate\Database\Seeder;

require_once __DIR__ . '/Concerns/SeedsFromCsv.php';

class CountyTableSeeder extends Seeder
{
    use SeedsFromCsv;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedFromCsv('counties', __DIR__ . '/../../data/counties.csv');
    }
}
