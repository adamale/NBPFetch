<?php
declare(strict_types=1);

namespace NBPFetch\Module\ExchangeRateTable\Parser;

use NBPFetch\Module\ExchangeRateTable\Structure\ExchangeRate;
use NBPFetch\Module\ExchangeRateTable\Structure\ExchangeRateCollection;
use NBPFetch\Module\ExchangeRateTable\Structure\ExchangeRateTable;
use NBPFetch\Module\ExchangeRateTable\Structure\ExchangeRateTableCollection;
use NBPFetch\Parser\ParserInterface;

/**
 * Class Parser
 * @package NBPFetch\Module\ExchangeRateTable\Parser
 */
class Parser implements ParserInterface
{
    /**
     * Creates an exchange rate table collection from fetched array.
     * @param array $fetchedExchangeRateTables
     * @return ExchangeRateTableCollection
     */
    public function parse(array $fetchedExchangeRateTables): ExchangeRateTableCollection
    {
        $exchangeRateTableCollection = new ExchangeRateTableCollection();
        foreach ($fetchedExchangeRateTables as $fetchedExchangeRateTable) {
            $exchangeRateTableCollection[] = $this->parseExchangeRateTable($fetchedExchangeRateTable);
        }

        return $exchangeRateTableCollection;
    }

    /**
     * @param array $fetchedExchangeRateTable
     * @return ExchangeRateTable
     */
    private function parseExchangeRateTable(array $fetchedExchangeRateTable): ExchangeRateTable
    {
        return new ExchangeRateTable(
            $fetchedExchangeRateTable["table"],
            $fetchedExchangeRateTable["no"],
            $fetchedExchangeRateTable["effectiveDate"],
            $this->parseExchangeRates($fetchedExchangeRateTable["rates"])
        );
    }

    /**
     * @param array $fetchedExchangeRates
     * @return ExchangeRateCollection
     */
    private function parseExchangeRates(array $fetchedExchangeRates): ExchangeRateCollection
    {
        $exchangeRateCollection = new ExchangeRateCollection();
        foreach ($fetchedExchangeRates as $exchangeRate) {
            $exchangeRateCollection[] = $this->parseExchangeRate($exchangeRate);
        }

        return $exchangeRateCollection;
    }

    /**
     * @param array $exchangeRate
     * @return ExchangeRate
     */
    private function parseExchangeRate(array $exchangeRate): ExchangeRate
    {
        return new ExchangeRate(
            (string) $exchangeRate["code"],
            (string) $exchangeRate["mid"]
        );
    }
}
