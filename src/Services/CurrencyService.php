<?php

namespace Mgcodeur\CurrencyConverter\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    public function convertAllCurrency($amount, $from, $result): array
    {
        $converted = [];

        if (array_key_exists($from, $result) && ! empty($result[$from])) {
            foreach ($result[$from] as $currency => $value) {
                $converted[$currency] = $value * $amount;
            }
        }

        return array_change_key_case($converted, CASE_UPPER);
    }

    public function getApiResult(string $from, ?string $to = null): Response
    {
        if (! $to) {
            return Http::get(config('currency-converter.api.url')."/{$from}.json");
        }

        return Http::get(config('currency-converter.api.url')."/{$from}/{$to}.json");
    }
}
