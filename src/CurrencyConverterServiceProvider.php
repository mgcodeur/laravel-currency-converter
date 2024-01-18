<?php

namespace Mgcodeur\CurrencyConverter;

use Mgcodeur\CurrencyConverter\Commands\CurrencyConverterCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CurrencyConverterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-currency-converter')
            ->hasConfigFile('currency-converter')
            ->hasMigrations(['create_history_rates_table'])
            ->hasCommand(CurrencyConverterCommand::class)
            ->hasTranslations();
    }
}
