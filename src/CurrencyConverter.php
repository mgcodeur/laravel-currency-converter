<?php

namespace Mgcodeur\CurrencyConverter;

use Exception;
use Mgcodeur\CurrencyConverter\Services\CurrencyService;
use Mgcodeur\CurrencyConverter\Traits\CurrencyConverterManager;

class CurrencyConverter
{
    use CurrencyConverterManager;

    protected string $from = '';

    protected string $to = '';

    protected float $amount = 0;

    protected array $currencies = [];

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
    public function currencies(): static
    {
        $response = $this->currencyService->fetchAllCurrencies();
        $result = $response->json();

        if (! $result) {
            throw new Exception('Something went wrong, please try again later');
        }

        $this->currencies = array_change_key_case($result, CASE_UPPER);

        return $this;
    }
}
