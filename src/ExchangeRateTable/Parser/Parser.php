<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable\Parser;

use NBPFetch\ExchangeRateTable\Structure\ExchangeRate;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateCollection;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateTable;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateTableCollection;

/**
 * Class Parser
 * @package NBPFetch\ExchangeRateTable\Parser
 */
class Parser
{
    /**
     * Creates an exchange rate table from fetched array.
     * @param array $fetchedExchangeRateTable
     * @return ExchangeRateTable
     */
    public function parse(array $fetchedExchangeRateTable): ExchangeRateTable
    {
        return new ExchangeRateTable(
            $fetchedExchangeRateTable["table"],
            $fetchedExchangeRateTable["no"],
            $fetchedExchangeRateTable["effectiveDate"],
            $this->parseFetchedExchangeRates($fetchedExchangeRateTable["rates"])
        );
    }

    /**
     * @param array $fetchedExchangeRates
     * @return ExchangeRateCollection
     */
    private function parseFetchedExchangeRates(array $fetchedExchangeRates): ExchangeRateCollection
    {
        $exchangeRateCollection = new ExchangeRateCollection();
        foreach ($fetchedExchangeRates as $exchangeRate) {
            $exchangeRateCollection[] = new ExchangeRate(
                (string) $exchangeRate["code"],
                (string) $exchangeRate["mid"]
            );
        }

        return $exchangeRateCollection;
    }

    /**
     * Creates an exchange rate table collection from fetched array.
     * @param array $fetchedExchangeRateTables
     * @return ExchangeRateTableCollection
     */
    public function parseCollection(array $fetchedExchangeRateTables): ExchangeRateTableCollection
    {
        $exchangeRateTableCollection = new ExchangeRateTableCollection();
        foreach ($fetchedExchangeRateTables as $fetchedExchangeRateTable) {
            $exchangeRateTableCollection[] = $this->parse($fetchedExchangeRateTable);
        }

        return $exchangeRateTableCollection;
    }
}
