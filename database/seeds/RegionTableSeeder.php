<?php

namespace Pirumart\Uganda\Locale\Database\Seeders;

use Illuminate\Database\Seeder;
use Pirumart\Uganda\Locale\Database\Seeders\Concerns\SeedsFromCsv;

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
        $this->seedFromCsv('regions', __DIR__ . '/../data/regions.csv');
    }
}
