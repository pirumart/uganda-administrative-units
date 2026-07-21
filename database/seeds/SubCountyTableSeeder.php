<?php

namespace Pirumart\Uganda\Locale\Database\Seeders;

use Illuminate\Database\Seeder;
use Pirumart\Uganda\Locale\Database\Seeders\Concerns\SeedsFromCsv;

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
        $this->seedFromCsv('sub_counties', __DIR__ . '/../data/sub_counties.csv');
    }
}
