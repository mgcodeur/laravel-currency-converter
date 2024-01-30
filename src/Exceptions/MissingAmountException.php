<?php

namespace Mgcodeur\CurrencyConverter\Exceptions;

class MissingAmountException extends \Exception
{
    protected $message = 'Amount is required, please use convert() or amount() method before getting the result.';

    protected $code = 400;
}
