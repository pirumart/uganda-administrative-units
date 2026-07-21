<?php

namespace Pirumart\Uganda\Locale;

use Pirumart\Uganda\Locale\Commands\SeedAdministrativeUnitsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AdministrativeUnitsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('administrative-units')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_uganda_administrative_units_table')
            ->hasCommand(SeedAdministrativeUnitsCommand::class);
    }
}
