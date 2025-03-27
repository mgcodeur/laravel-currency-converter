<?php

namespace Mgcodeur\CurrencyConverter\Exceptions;

/**
 * Class MissingAmountException
 *
 * This exception is thrown when an amount is missing.
 * Ensure that the `convert()` or `amount()` method is called before attempting to get the result.
 */
class MissingAmountException extends \Exception
{
    protected $message = 'Amount is required, please use convert() or amount() method before getting the result.';

    protected $code = 400;
}
