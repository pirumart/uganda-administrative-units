<?php

namespace Pirumart\Uganda\Locale;

use Illuminate\Support\ServiceProvider;
use Pirumart\Uganda\Locale\Commands\SeedAdministrativeUnitsCommand;

class AdministrativeUnitsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/administrative-units.php' => config_path('administrative-units.php'),
                ],
                'config'
            );

            $this->publishes(
                [
                    __DIR__ . '/../resources/views' => base_path('resources/views/vendor/administrative-units'),
                ],
                'views'
            );

            $migrationFileName = 'create_uganda_administrative_units_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes(
                    [
                        __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                    ],
                    'migrations'
                );
            }

            $this->commands([SeedAdministrativeUnitsCommand::class,]);
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'administrative-units');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/administrative-units.php', 'administrative-units');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
