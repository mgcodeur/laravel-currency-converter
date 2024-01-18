<?php

namespace Mgcodeur\CurrencyConverter\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mgcodeur\CurrencyConverter\CurrencyConverterServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mgcodeur\\CurrencyConverter\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            CurrencyConverterServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-currency-converter_table.php.stub';
        $migration->up();
        */
    }
}
