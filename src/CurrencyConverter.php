<?php

namespace Mgcodeur\CurrencyConverter;

use Mgcodeur\CurrencyConverter\Exceptions\NetworkException;
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
    public function convert(float $amount = 0): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return $this
     */
    public function amount(float $amount = 0): static
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
     * @return $this
     *
     * @throws NetworkException
     */
    public function currencies(): static
    {
        $response = $this->currencyService->fetchAllCurrencies();
        $result = $response->json();

        if (! $result) {
            throw new NetworkException();
        }

        $this->currencies = array_change_key_case($result, CASE_UPPER);

        return $this;
    }
}
