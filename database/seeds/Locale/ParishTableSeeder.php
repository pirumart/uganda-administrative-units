<?php

use Illuminate\Database\Seeder;

require_once __DIR__ . '/Concerns/SeedsFromCsv.php';

class ParishTableSeeder extends Seeder
{
    use SeedsFromCsv;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedFromCsv('parishes', __DIR__ . '/../../data/parishes.csv');
    }
}
