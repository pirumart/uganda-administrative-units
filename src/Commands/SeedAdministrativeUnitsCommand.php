<?php

namespace Pirumart\Uganda\Locale\Commands;

use Illuminate\Console\Command;
use Pirumart\Uganda\Locale\Database\Seeders\UgandaLocaleSeeder;

class SeedAdministrativeUnitsCommand extends Command
{
    public $signature = 'uganda-administrative-units:seed';

    public $description = 'Seed the regions, districts, counties, sub-counties, parishes, and villages tables with Uganda administrative unit data';

    public function handle()
    {
        (new UgandaLocaleSeeder)->run();

        $this->comment('Uganda administrative units seeded.');

        return self::SUCCESS;
    }
}
