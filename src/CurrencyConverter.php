<?php

namespace Mgcodeur\CurrencyConverter;

use Mgcodeur\CurrencyConverter\Exceptions\NetworkException;
use Mgcodeur\CurrencyConverter\Services\CurrencyService;
use Mgcodeur\CurrencyConverter\Traits\CurrencyConverterManager;

/**
 * @category Currency Converter
 *
 * @author ANDRIANAMBININA Iharena Jimmy Raphaël (Mgcodeur)
 * @author <mgcodeur@gmail.com>
 * @copyright 2025 ANDRIANAMBININA Iharena Jimmy Raphaël (Mgcodeur)
 * @license https://opensource.org/licenses/GPL-3.0 GNU General Public License 3.0
 *
 * @version 1.0.7
 *
 * @link https://github.com/mgcodeur
 */

/**
 * Class CurrencyConverter
 * Class to handle currency conversion operations.
 */
class CurrencyConverter
{
    use CurrencyConverterManager;

    protected string $from = '';

    protected string $to = '';

    protected float $amount = 0;

    protected array $currencies = [];

    /**
     * CurrencyConverter constructor.
     *
     * @param  CurrencyService  $currencyService  The service used to handle currency-related operations.
     */
    public function __construct(private CurrencyService $currencyService) {}

    /**
     * Convert the given amount to the desired currency.
     *
     * @param  float  $amount  The amount to be converted. Defaults to 0.
     * @return static Returns the current instance for method chaining.
     */
    public function convert(float $amount = 0): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set the amount to be converted.
     *
     * @param  float  $amount  The amount to set (default is 0).
     * @return static Returns the current instance for method chaining.
     */
    public function amount(float $amount = 0): static
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set the currency to convert from.
     *
     * @param  string  $from  The currency code to convert from (e.g., "USD", "EUR").
     * @return static Returns the current instance for method chaining.
     */
    public function from(string $from): static
    {
        $this->from = mb_strtolower($from);

        return $this;
    }

    /**
     * Set the target currency for the conversion.
     *
     * @param  string  $to  The target currency code (e.g., 'usd', 'eur').
     * @return static Returns the current instance for method chaining.
     */
    public function to(string $to): static
    {
        $this->to = mb_strtolower($to);

        return $this;
    }

    /**
     * Fetches all available currencies.
     *
     * @return static Returns the current instance for method chaining.
     *
     * @throws NetworkException Thrown if the currency service response is empty or cannot be fetched.
     */
    public function currencies(): static
    {
        $response = $this->currencyService->fetchAllCurrencies();
        $result = $response->json();

        if (! $result) {
            throw new NetworkException;
        }

        $this->currencies = array_change_key_case($result, CASE_UPPER);

        return $this;
    }
}
