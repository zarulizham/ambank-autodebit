<?php

namespace ZarulIzham\AutoDebit;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ZarulIzham\AutoDebit\Commands\AutoDebitCommand;

class AutoDebitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-ambank-autodebit')
            ->hasConfigFile('autodebit')
            ->hasViews()
            ->hasMigration('create_laravel-ambank-autodebit_table')
            ->hasCommand(AutoDebitCommand::class);
    }
}