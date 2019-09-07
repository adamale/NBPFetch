<?php
declare(strict_types=1);

namespace NBPFetch\Module\CurrencyRate\Parser;

use NBPFetch\Module\CurrencyRate\Structure\CurrencyRate;
use NBPFetch\Module\CurrencyRate\Structure\CurrencyRateCollection;
use NBPFetch\Module\CurrencyRate\Structure\CurrencyRateSeries;

/**
 * Class Parser
 * @package NBPFetch\Module\CurrencyRate\Parser
 */
class Parser
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
            $this->parseFetchedCurrencyRates($fetchedCurrencyRateSeries["rates"])
        );
    }

    /**
     * Creates a currency rate collection from rates array.
     * @param array $fetchedCurrencyRates
     * @return CurrencyRateCollection
     */
    private function parseFetchedCurrencyRates(array $fetchedCurrencyRates): CurrencyRateCollection
    {
        $currencyRateCollection = new CurrencyRateCollection();
        foreach ($fetchedCurrencyRates as $rate) {
            $currencyRateCollection[] = new CurrencyRate(
                (string) $rate["no"],
                (string) $rate["effectiveDate"],
                (string) $rate["mid"]
            );
        }

        return $currencyRateCollection;
    }
}
