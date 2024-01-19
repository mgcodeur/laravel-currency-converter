<?php

namespace Mgcodeur\CurrencyConverter\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    private string $baseUrl = 'https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies';

    public function convertAllCurrency($amount, $from, $result, $format = false): array
    {
        $converted = [];

        if (array_key_exists($from, $result) && ! empty($result[$from])) {
            foreach ($result[$from] as $currency => $value) {
                if ($format) {
                    $converted[$currency] = number_format(
                        num: $value * $amount,
                        decimals: config('currency-converter.currency.format.decimals'),
                        decimal_separator: config('currency-converter.currency.format.decimal_separator'),
                        thousands_separator: config('currency-converter.currency.format.thousand_separator')
                    );
                } else {
                    $converted[$currency] = $value * $amount;
                }
            }
        }

        return array_change_key_case($converted, CASE_UPPER);
    }

    public function fetchAllCurrencies(): Response
    {
        return Http::get($this->baseUrl.'.json');
    }

    public function runConversionFrom(string $from, ?string $to = null): Response
    {
        if (! $to) {
            return Http::get($this->baseUrl."/{$from}.json");
        }

        return Http::get($this->baseUrl."/{$from}/{$to}.json");
    }
}
