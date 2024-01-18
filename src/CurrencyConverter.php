<?php

namespace Mgcodeur\CurrencyConverter;

use Exception;
use Mgcodeur\CurrencyConverter\Services\CurrencyService;

class CurrencyConverter
{
    private string $from = '';

    private string $to = '';

    private float $amount = 0;

    public function __construct(private CurrencyService $currencyService)
    {
    }

    /**
     * @return $this
     */
    public function convert(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return $this
     */
    public function amount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return $this
     */
    public function from(string $from): static
    {
        $this->from = mb_strtolower($from);

        return $this;
    }

    /**
     * @return $this
     */
    public function to(string $to): static
    {
        $this->to = mb_strtolower($to);

        return $this;
    }

    /**
     * @throws Exception
     */
    public function get(): float|int|array
    {
        $this->verifyDataBeforeGettingResults();

        $response = $this->currencyService->getApiResult(
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
                result: $result
            );
        }

        return $result[$this->to] * $this->amount;
    }

    /**
     * @throws Exception
     */
    private function verifyDataBeforeGettingResults(): void
    {
        if (! $this->amount) {
            throw new Exception('Amount is required, please use convert() or amount() method before getting the result');
        }
        if (! $this->from) {
            throw new Exception('From currency is required, please specify currency using from() method before getting the result');
        }
    }
}
