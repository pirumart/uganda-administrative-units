<?php

use Illuminate\Database\Seeder;

require_once __DIR__ . '/Concerns/SeedsFromCsv.php';

class RegionTableSeeder extends Seeder
{
    use SeedsFromCsv;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedFromCsv('regions', __DIR__ . '/../../data/regions.csv');
    }
}
