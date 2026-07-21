<?php

namespace Pirumart\Uganda\Locale\Tests;

use Illuminate\Support\Facades\Artisan;
use Pirumart\Uganda\Locale\AdministrativeUnitsServiceProvider;

class AdministrativeUnitsServiceProviderTest extends TestCase
{
    /** @test */
    public function it_publishes_the_migration_stub_under_the_expected_filename()
    {
        Artisan::call('vendor:publish', [
            '--provider' => AdministrativeUnitsServiceProvider::class,
            '--tag' => 'administrative-units-migrations',
            '--force' => true,
        ]);

        $published = glob(database_path('migrations/*_create_uganda_administrative_units_table.php'));

        $this->assertNotEmpty(
            $published,
            'Expected a published migration file matching *_create_uganda_administrative_units_table.php'
        );
    }
}
