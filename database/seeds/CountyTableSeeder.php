<?php

namespace Pirumart\Uganda\Locale\Database\Seeders;

use Illuminate\Database\Seeder;
use Pirumart\Uganda\Locale\Database\Seeders\Concerns\SeedsFromCsv;

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
        $this->seedFromCsv('counties', __DIR__.'/../data/counties.csv');
    }
}
