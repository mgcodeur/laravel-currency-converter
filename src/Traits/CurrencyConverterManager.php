<?php

namespace Mgcodeur\CurrencyConverter\Traits;

use Mgcodeur\CurrencyConverter\Exceptions\MissingAmountException;
use Mgcodeur\CurrencyConverter\Exceptions\MissingCurrencyException;
use Mgcodeur\CurrencyConverter\Exceptions\NetworkException;

/**
 * Trait CurrencyConverterManager
 *
 * Provides functionality for managing currency conversions.
 */
trait CurrencyConverterManager
{
    /**
     * Retrieves the converted currency value or a list of all converted currencies.
     *
     * @param  bool  $format  Whether to format the result as a number with specific formatting options.
     * @return array|string|float Returns an array of all converted currencies if `$to` is not set,
     *                            a formatted string if `$format` is true, or a float value otherwise.
     *
     * @throws NetworkException If there is an issue with the network during the conversion process.
     * @throws MissingAmountException If the amount to be converted is not provided.
     * @throws MissingCurrencyException If the source or target currency is not provided.
     */
    public function get($format = false)
    {
        $this->verifyDataBeforeGettingResults();

        if ($this->currencies) {
            return $this->currencies;
        }

        $result = $this->currencyService->runConversionFrom(
            from: $this->from,
            to: $this->to
        );

        if (! $this->to) {
            return $this->currencyService->convertAllCurrency(
                amount: $this->amount,
                result: $result[$this->from],
                format: $format
            );
        }

        if ($format) {
            return number_format(
                num: $result[$this->to] * $this->amount,
                decimals: config('currency-converter.currency.format.decimals'),
                decimal_separator: config('currency-converter.currency.format.decimal_separator'),
                thousands_separator: config('currency-converter.currency.format.thousand_separator')
            );
        } else {
            return $result[$this->to] * $this->amount;
        }
    }

    /**
     * Formats and retrieves the converted currency value.
     *
     * This method returns the converted currency value in the specified format.
     * The return type can vary depending on the implementation.
     *
     * @return float|array|int|string The formatted converted currency value.
     *
     * @throws NetworkException If there is a network-related issue during the conversion process.
     * @throws MissingAmountException If the amount to be converted is not provided.
     * @throws MissingCurrencyException If the currency to be converted is not specified.
     */
    public function format(): float|array|int|string
    {
        return $this->get(true);
    }

    /**
     * Verifies that the required data is present before attempting to get results.
     *
     * This method checks if the `amount` and `from` currency are set, as well as the `currencies` array.
     * If any of these are missing, it throws the appropriate exception.
     *
     * @throws MissingAmountException If the amount and currencies are not set.
     * @throws MissingCurrencyException If the from currency and currencies are not set.
     */
    private function verifyDataBeforeGettingResults(): void
    {
        if (! $this->amount && ! $this->currencies) {
            throw new MissingAmountException;
        }
        if (! $this->from && ! $this->currencies) {
            throw new MissingCurrencyException;
        }
    }
}
