<?php

namespace Mgcodeur\CurrencyConverter\Exceptions;

/**
 * Exception thrown when a required currency is missing.
 *
 * This exception is used to indicate that the `from()` method must be called
 * to specify the source currency before attempting to get the result.
 */
class MissingCurrencyException extends \Exception
{
    protected $message = '`From` is required, please specify currency using from() method before getting the result.';

    protected $code = 400;
}
