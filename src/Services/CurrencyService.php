<?php

namespace Mgcodeur\CurrencyConverter\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Mgcodeur\CurrencyConverter\Exceptions\NetworkException;

class CurrencyService
{
    private string $baseUrl = 'https://latest.currency-api.pages.dev/v1/currencies';

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

    public function fetchAllCurrencies(): Response
    {
        return Http::withoutVerifying()->get($this->baseUrl.'.json');
    }

    public function runConversionFrom(string $from, ?string $to = '')
    {
        $response = Http::withoutVerifying()
            ->get($this->baseUrl."/{$from}.json");

        if ($response->failed()) {
            throw new NetworkException();
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
