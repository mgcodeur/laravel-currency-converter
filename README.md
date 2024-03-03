# Laravel Currency Converter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mgcodeur/laravel-currency-converter.svg?style=flat-square)](https://packagist.org/packages/mgcodeur/laravel-currency-converter)


[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mgcodeur/laravel-currency-converter/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mgcodeur/laravel-currency-converter/?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mgcodeur/laravel-currency-converter/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mgcodeur/laravel-currency-converter/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mgcodeur/laravel-currency-converter.svg?style=flat-square)](https://packagist.org/packages/mgcodeur/laravel-currency-converter)

Laravel Currency Converter: Effortlessly convert currencies in your Laravel applications, no API key required. It's fast, easy, and completely free.

## 📦 Installation

You can install the package via composer:

```bash
composer require mgcodeur/laravel-currency-converter
```

After Composer has installed the Laravel Currency Converter package, you may run the `currency-converter:install` Artisan command:

```bash
php artisan currency-converter:install
```
## ✍🏻 Basic Usage

### Convert money from one to another

```php
// convert 10 USD to MGA
$convertedAmount = CurrencyConverter::convert(10)
            ->from('USD')
            ->to('MGA')
            ->get();

dd($convertedAmount);
```
**NB: Don't Forget to import the CurrencyConverter Facades**

```php
use Mgcodeur\CurrencyConverter\Facades\CurrencyConverter;
```

### Convert all money from one

You can convert all money from one currency when you don't specify the `to` method.

```php
// convert 5 EUR to all currencies
$convertedAmount = CurrencyConverter::convert(5)
            ->from('EUR')
            ->get();

dd($convertedAmount);
```

### Get all currencies

To get all currencies, you can use the `currencies` method.

```php
$currencies = CurrencyConverter::currencies()->get();

dd($currencies);
```

### Format output result

Instead of using the `get` method, you can use the `format` method to format the output result.

```php
// convert 10 USD to EUR and format the result
$convertedAmount = CurrencyConverter::convert(10)
            ->from('USD')
            ->to('EUR') // you don't need to specify the to method if you want to convert all currencies
            ->format();

dd($convertedAmount);
```

By default, thousand separator is a comma (,) and decimal separator is a dot (.). You can change these separators in published config file (`config/currency-converter.php`).
<br/>
If you open the config file, you will see the following code:

```php
return [
    'currency' => [
        'format' => [
            'decimals' => 2, // change this to 0 if you want result like 1.000, or 3 if you want result like 1.000.000
            'decimal_separator' => ',', // change this to '.' if you want result like 1.000,00, or space if you want result like 1 000,00
            'thousand_separator' => '.', // change this to ',' if you want result like 1,000.00, or '.' if you want result like 1 000.00
        ]
    ],
];
```

### 🪴 Project Activity
![Alt](https://repobeats.axiom.co/api/embed/25c035763caeb00b127eb4ce26447d4b5a36a8f5.svg "Project Activity")