<?php

namespace Mgcodeur\CurrencyConverter\Exceptions;

class NetworkException extends \Exception
{
    protected $message = 'Something went wrong with the network, please try again later.';

    protected $code = 400;
}
