<?php

namespace ZarulIzham\AutoDebit;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ZarulIzham\AutoDebit\Commands\AutoDebitAuthenticateCommand;

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
            ->hasRoute('web')
            ->hasMigrations(
                'create_autodebit_bic_codes_table',
                'create_autodebit_callback_transactions_table',
                'create_autodebit_debit_transactions_table',
                'create_autodebit_registrations_table',
            )
            ->hasCommand(AutoDebitAuthenticateCommand::class);
    }
}
