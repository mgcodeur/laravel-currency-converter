<?php

namespace Mgcodeur\CurrencyConverter\Exceptions;

/**
 * Class NetworkException
 *
 * This exception is thrown when there is a network-related issue.
 * It provides a default error message and HTTP status code.
 */
class NetworkException extends \Exception
{
    protected $message = 'Something went wrong with the network, please try again later.';

    protected $code = 500;
}
