<?php

namespace SoftwareGalaxy\NidaClient;

use SoftwareGalaxy\NidaClient\Commands\NidaClientCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NidaClientServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('nida-client')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_nida-client_table')
            ->hasCommand(NidaClientCommand::class);
    }
}
