<?php

namespace Mgcodeur\CurrencyConverter\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Mgcodeur\CurrencyConverter\Exceptions\NetworkException;

/**
 * Class CurrencyService
 * Class to handle currency api operations.
 */
class CurrencyService
{
    private string $baseUrl = 'https://latest.currency-api.pages.dev/v1/currencies';

    /**
     * Converts a given amount to all available currencies.
     *
     * @param  float|int  $amount  The amount to be converted.
     * @param  array  $result  An array to store the conversion results.
     * @param  bool  $format  Whether to format the converted values (e.g., as strings with currency symbols).
     * @return array An array containing the converted values for all currencies.
     */
    public function convertAllCurrency($amount, array $result, bool $format = false): array
    {
        $converted = [];

        if (! empty($result)) {
            foreach ($result as $currency => $value) {
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

    /**
     * Fetches all available currencies from the external API.
     *
     * @return \Illuminate\Http\Client\Response The HTTP response containing the currencies data.
     */
    public function fetchAllCurrencies(): Response
    {
        return Http::withoutVerifying()->get($this->baseUrl.'.json');
    }

    /**
     * Converts a currency from the specified source currency to the target currency.
     *
     * @param  string  $from  The source currency code (e.g., "USD").
     * @param  string|null  $to  The target currency code (e.g., "EUR"). Defaults to an empty string if not provided.
     * @return mixed The result of the currency conversion.
     */
    public function runConversionFrom(string $from, ?string $to = '')
    {
        $response = Http::withoutVerifying()
            ->get($this->baseUrl."/{$from}.json");

        if ($response->failed()) {
            throw new NetworkException;
        }

        $datas = $response->json();

        if ($to && array_key_exists($from, $datas)) {
            $datas = $datas[$from][$to];
        }

        if (is_numeric($datas)) {
            $datas = [
                $to => $datas,
            ];
        }

        return $datas;
    }
}
