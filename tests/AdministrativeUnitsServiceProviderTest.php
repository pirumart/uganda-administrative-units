<?php

use Illuminate\Support\Facades\Artisan;
use Pirumart\Uganda\Locale\AdministrativeUnitsServiceProvider;

it('publishes the migration stub under the expected filename', function () {
    Artisan::call('vendor:publish', [
        '--provider' => AdministrativeUnitsServiceProvider::class,
        '--tag' => 'administrative-units-migrations',
        '--force' => true,
    ]);

    $published = glob(database_path('migrations/*_create_uganda_administrative_units_table.php'));

    expect($published)->not->toBeEmpty();
});
