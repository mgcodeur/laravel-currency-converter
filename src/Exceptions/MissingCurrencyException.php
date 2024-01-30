<?php

namespace Mgcodeur\CurrencyConverter\Exceptions;

class MissingCurrencyException extends \Exception
{
    protected $message = '`From` is required, please specify currency using from() method before getting the result.';

    protected $code = 400;
}
