<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate\TableResolver;

use NBPFetch\Exception\InvalidCurrencyException;

/**
 * Class TableResolver
 * @package NBPFetch\CurrencyRate\TableResolver
 */
class TableResolver implements TableResolverInterface
{
    /**
     * @var string[] ISO 4217 currency codes that are defined in table A.
     */
    private const TABLE_A = [
        "AUD", "BGN", "BRL", "CAD", "CHF", "CLP", "CNY", "CZK", "DKK", "EUR", "GBP", "HKD", "HRK", "HUF",
        "IDR", "ILS", "INR", "ISK", "JPY", "KRW", "MXN", "MYR", "NOK", "NZD", "PHP", "RON", "RUB", "SEK",
        "SGD", "THB", "TRY", "UAH", "USD", "XDR", "ZAR"
    ];

    /**
     * @var string[] ISO 4217 currency codes that are defined in table B.
     */
    private const TABLE_B = [
        "AED", "AFN", "ALL", "AMD", "ANG", "AOA", "ARS", "AWG", "AZN", "BAM", "BBD", "BDT", "BHD", "BIF",
        "BND", "BOB", "BSD", "BWP", "BYN", "BZD", "CDF", "COP", "CRC", "CUP", "CVE", "DJF", "DOP", "DZD",
        "EGP", "ERN", "ETB", "FJD", "GEL", "GHS", "GIP", "GMD", "GNF", "GTQ", "GYD", "HNL", "HTG", "IQD",
        "IRR", "JMD", "JOD", "KES", "KGS", "KHR", "KMF", "KWD", "KZT", "LAK", "LBP", "LKR", "LRD", "LSL",
        "LYD", "MAD", "MDL", "MGA", "MKD", "MMK", "MNT", "MOP", "MRU", "MUR", "MVR", "MWK", "MZN", "NAD",
        "NGN", "NIO", "NPR", "OMR", "PAB", "PEN", "PGK", "PKR", "PYG", "QAR", "RSD", "RWF", "SAR", "SBD",
        "SCR", "SDG", "SLL", "SOS", "SRD", "SSP", "STN", "SVC", "SYP", "SZL", "TJS", "TMT", "TND", "TOP",
        "TTD",  "TWD", "TZS", "UGX", "UYU", "UZS", "VES", "VND", "VUV", "WST", "XAF", "XCD", "XOF", "XPF",
        "YER", "ZMW"
    ];

    /**
     * @param string $currency
     * @return string
     * @throws InvalidCurrencyException
     */
    public function resolve(string $currency): string
    {
        $currency = mb_strtoupper($currency);

        if (in_array($currency, self::TABLE_A)) {
            $table = "A";
        } elseif (in_array($currency, self::TABLE_B)) {
            $table = "B";
        } else {
            throw new InvalidCurrencyException("Currency is not defined in the tables");
        }

        return $table;
    }
}
