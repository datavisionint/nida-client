<?php

namespace SoftwareGalaxy\NIDAClient;

use SoftwareGalaxy\NIDAClient\Commands\NIDAClientCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NIDAClientServiceProvider extends PackageServiceProvider
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
            ->hasCommand(NIDAClientCommand::class);
    }
}
