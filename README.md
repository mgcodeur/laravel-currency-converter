# Laravel Currency Converter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mgcodeur/laravel-currency-converter.svg?style=flat-square)](https://packagist.org/packages/mgcodeur/laravel-currency-converter)

[//]: # (TODO: write tests)
[//]: # ([![GitHub Tests Action Status]&#40;https://img.shields.io/github/actions/workflow/status/mgcodeur/laravel-currency-converter/run-tests.yml?branch=main&label=tests&style=flat-square&#41;]&#40;https://github.com/mgcodeur/laravel-currency-converter/actions?query=workflow%3Arun-tests+branch%3Amain&#41;)

[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mgcodeur/laravel-currency-converter/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mgcodeur/laravel-currency-converter/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mgcodeur/laravel-currency-converter.svg?style=flat-square)](https://packagist.org/packages/mgcodeur/laravel-currency-converter)

Laravel Currency Converter: Effortlessly convert currencies in your Laravel applications, no API key required. It's fast, easy, and completely free.

## Installation

You can install the package via composer:

```bash
composer require mgcodeur/laravel-currency-converter
```

After Composer has installed the Laravel Currency Converter package, you may run the `currency-converter:install` Artisan command:

```bash
php artisan currency-converter:install
```
## Basic Usage

### Convert money from one to another

```php
$convertedAmount = CurrencyConverter::convert(10)
            ->from('USD')
            ->to('MGA')
            ->get();

dd($convertedAmount);
```
### Convert all money from one

You can convert all money from one currency when you don't specify the `to` method.

```php
$convertedAmount = CurrencyConverter::convert(10)
            ->from('EUR')
            ->get();

dd($convertedAmount);
```
