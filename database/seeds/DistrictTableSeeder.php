<?php

namespace Pirumart\Uganda\Locale\Database\Seeders;

use Illuminate\Database\Seeder;
use Pirumart\Uganda\Locale\Database\Seeders\Concerns\SeedsFromCsv;

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
        $this->seedFromCsv('districts', __DIR__ . '/../data/districts.csv');
    }
}
