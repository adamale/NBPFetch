<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyTable;

/**
 * Class CurrencyTableA
 * @package NBPFetch\CurrencyTable
 */
class CurrencyTableA extends AbstractCurrencyTable
{
    /**
     * @var string
     */
    public const TABLE_TYPE = "A";

    /**
     * @return array
     */
    public function getCurrencies(): array
    {
        return [
            "AUD", "BGN", "BRL", "CAD", "CHF", "CLP", "CNY", "CZK", "DKK", "EUR", "GBP", "HKD", "HRK", "HUF",
            "IDR", "ILS", "INR", "ISK", "JPY", "KRW", "MXN", "MYR", "NOK", "NZD", "PHP", "RON", "RUB", "SEK",
            "SGD", "THB", "TRY", "UAH", "USD", "XDR", "ZAR"
        ];
    }
}
