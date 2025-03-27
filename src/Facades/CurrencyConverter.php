<?php

namespace Mgcodeur\CurrencyConverter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * CurrencyConverter Facade
 *
 * This facade provides a static interface to the underlying
 * \Mgcodeur\CurrencyConverter\CurrencyConverter class.
 *
 * @method static static convert(float $amount = 0)
 * @method static static amount(float $amount = 0)
 * @method static static from(string $from)
 * @method static static to(string $to)
 * @method static static currencies()
 * @method static array|string|float get($format = false)
 * @method static array|string|float format()
 */
class CurrencyConverter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * This method is used to define the accessor for the facade,
     * which allows static method calls to be routed to the underlying
     * service or class instance.
     *
     * @return string The fully qualified class name of the service being accessed.
     */
    protected static function getFacadeAccessor()
    {
        return \Mgcodeur\CurrencyConverter\CurrencyConverter::class;
    }
}
