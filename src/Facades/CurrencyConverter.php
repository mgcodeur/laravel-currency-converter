<?php

namespace Mgcodeur\CurrencyConverter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mgcodeur\CurrencyConverter\CurrencyConverter
 */
class CurrencyConverter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mgcodeur\CurrencyConverter\CurrencyConverter::class;
    }
}
