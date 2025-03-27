<?php

namespace Mgcodeur\CurrencyConverter;

use Mgcodeur\CurrencyConverter\Commands\CurrencyConverterCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

/**
 * Class CurrencyConverterServiceProvider
 *
 * This class is a Package Service Provider for the Laravel Currency Converter
 *
 * @see https://github.com/spatie/laravel-package-tools
 */
class CurrencyConverterServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * @param  Package  $package  The package instance to configure.
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-currency-converter')
            ->hasConfigFile('currency-converter')
            ->hasMigrations(['create_history_rates_table'])
            ->hasCommand(CurrencyConverterCommand::class)
            ->hasTranslations();
    }
}
