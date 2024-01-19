<?php

namespace Mgcodeur\CurrencyConverter\Traits;

use Exception;

trait CurrencyConverterManager
{
    /**
     * @throws Exception
     */
    public function get($format = false): float|int|array|string
    {
        $this->verifyDataBeforeGettingResults();

        if ($this->currencies) {
            return $this->currencies;
        }

        $response = $this->currencyService->runConversionFrom(
            from: $this->from,
            to: $this->to
        );

        if ($response->failed() || ! $response->json()) {
            throw new Exception('Something went wrong, please try again later');
        }

        $result = $response->json();

        if (! $this->to) {
            return $this->currencyService->convertAllCurrency(
                amount: $this->amount,
                from: $this->from,
                result: $result,
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
     * @throws Exception
     */
    public function format(): float|array|int|string
    {
        return $this->get(true);
    }

    /**
     * @throws Exception
     */
    private function verifyDataBeforeGettingResults(): void
    {
        if (! $this->amount && ! $this->currencies) {
            throw new Exception('Amount is required, please use convert() or amount() method before getting the result');
        }
        if (! $this->from && ! $this->currencies) {
            throw new Exception('From currency is required, please specify currency using from() method before getting the result');
        }
    }
}
