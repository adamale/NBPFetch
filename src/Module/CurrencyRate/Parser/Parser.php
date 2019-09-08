<?php
declare(strict_types=1);

namespace NBPFetch\Module\CurrencyRate\Parser;

use NBPFetch\Module\CurrencyRate\Structure\CurrencyRate;
use NBPFetch\Module\CurrencyRate\Structure\CurrencyRateCollection;
use NBPFetch\Module\CurrencyRate\Structure\CurrencyRateSeries;
use NBPFetch\Parser\ParserInterface;

/**
 * Class Parser
 * @package NBPFetch\Module\CurrencyRate\Parser
 */
class Parser implements ParserInterface
{
    /**
     * Creates a currency rate series from fetched array.
     * @param array $fetchedCurrencyRateSeries
     * @return CurrencyRateSeries
     */
    public function parse(array $fetchedCurrencyRateSeries): CurrencyRateSeries
    {
        return new CurrencyRateSeries(
            $fetchedCurrencyRateSeries["table"],
            $fetchedCurrencyRateSeries["currency"],
            $fetchedCurrencyRateSeries["code"],
            $this->parseCurrencyRates($fetchedCurrencyRateSeries["rates"])
        );
    }

    /**
     * @param array $fetchedCurrencyRates
     * @return CurrencyRateCollection
     */
    private function parseCurrencyRates(array $fetchedCurrencyRates): CurrencyRateCollection
    {
        $currencyRateCollection = new CurrencyRateCollection();
        foreach ($fetchedCurrencyRates as $rate) {
            $currencyRateCollection[] = $this->parseCurrencyRate($rate);
        }

        return $currencyRateCollection;
    }

    /**
     * @param array $rate
     * @return CurrencyRate
     */
    private function parseCurrencyRate(array $rate): CurrencyRate
    {
        return new CurrencyRate(
            (string) $rate["no"],
            (string) $rate["effectiveDate"],
            (string) $rate["mid"]
        );
    }
}
