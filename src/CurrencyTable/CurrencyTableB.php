<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyTable;

/**
 * Class CurrencyTableB
 * @package NBPFetch\CurrencyTable
 */
class CurrencyTableB extends AbstractCurrencyTable
{
    /**
     * @var string
     */
    public const TABLE_TYPE = "B";

    /**
     * @return array
     */
    public function getCurrencies(): array
    {
        return [
            "AED", "AFN", "ALL", "AMD", "ANG", "AOA", "ARS", "AWG", "AZN", "BAM", "BBD", "BDT", "BHD", "BIF",
            "BND", "BOB", "BSD", "BWP", "BYN", "BZD", "CDF", "COP", "CRC", "CUP", "CVE", "DJF", "DOP", "DZD",
            "EGP", "ERN", "ETB", "FJD", "GEL", "GHS", "GIP", "GMD", "GNF", "GTQ", "GYD", "HNL", "HTG", "IQD",
            "IRR", "JMD", "JOD", "KES", "KGS", "KHR", "KMF", "KWD", "KZT", "LAK", "LBP", "LKR", "LRD", "LSL",
            "LYD", "MAD", "MDL", "MGA", "MKD", "MMK", "MNT", "MOP", "MRU", "MUR", "MVR", "MWK", "MZN", "NAD",
            "NGN", "NIO", "NPR", "OMR", "PAB", "PEN", "PGK", "PKR", "PYG", "QAR", "RSD", "RWF", "SAR", "SBD",
            "SCR", "SDG", "SLL", "SOS", "SRD", "SSP", "STN", "SVC", "SYP", "SZL", "TJS", "TMT", "TND", "TOP",
            "TTD", "TWD", "TZS", "UGX", "UYU", "UZS", "VES", "VND", "VUV", "WST", "XAF", "XCD", "XOF", "XPF",
            "YER", "ZMW"
        ];
    }
}
