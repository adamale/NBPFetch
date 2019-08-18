<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\ExchangeRateTable;

use NBPFetch\NBPApi\ApiCaller\AbstractApiCaller;
use NBPFetch\Structure\ExchangeRate\ExchangeRate;
use NBPFetch\Structure\ExchangeRate\ExchangeRateCollection;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTable;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTableCollection;
use UnexpectedValueException;

/**
 * Class ApiCaller
 * @package NBPFetch\NBPApi\ExchangeRateTable
 */
class ApiCaller extends AbstractApiCaller
{
    /**
     * @var string API_SUBSET API Subset that returns exchange rate table data.
     */
    private const API_SUBSET = "exchangerates/tables/";

    /**
     * Returns a single exchange rate table from given URL.
     * @param string $path
     * @return ExchangeRateTable|null
     * @throws UnexpectedValueException
     */
    public function getSingle(string $path): ?ExchangeRateTable
    {
        $fetchedExchangeRateTables = $this->getNBPApi()->fetch(self::API_SUBSET . $path);
        return $this->createExchangeRateTable($fetchedExchangeRateTables[0]);
    }

    /**
     * Returns a set of exchange rate tables from given URL.
     * @param string $path
     * @return ExchangeRateTableCollection
     * @throws UnexpectedValueException
     */
    public function getCollection(string $path): ?ExchangeRateTableCollection
    {
        $fetchedExchangeRateTables = $this->getNBPApi()->fetch(self::API_SUBSET . $path);
        return $this->createExchangeRateTableCollection($fetchedExchangeRateTables);
    }

    /**
     * Creates an ExchangeRateTable object from fetched array.
     * @param array $fetchedExchangeRateTable
     * @return ExchangeRateTable
     */
    private function createExchangeRateTable(array $fetchedExchangeRateTable): ExchangeRateTable
    {
        $exchangeRateCollection = new ExchangeRateCollection();
        foreach ($fetchedExchangeRateTable["rates"] as $exchangeRate) {
            $exchangeRateCollection[] = new ExchangeRate($exchangeRate["code"], (string) $exchangeRate["mid"]);
        }

        return new ExchangeRateTable(
            $fetchedExchangeRateTable["table"],
            $fetchedExchangeRateTable["no"],
            $fetchedExchangeRateTable["effectiveDate"],
            $exchangeRateCollection
        );
    }

    /**
     * Creates an ExchangeRateTableCollection object from fetched array.
     * @param array $fetchedExchangeRateTables
     * @return ExchangeRateTableCollection
     */
    private function createExchangeRateTableCollection(array $fetchedExchangeRateTables): ExchangeRateTableCollection
    {
        $exchangeRateTableCollection = new ExchangeRateTableCollection();
        foreach ($fetchedExchangeRateTables as $fetchedExchangeRateTable) {
            $exchangeRateTableCollection[] = $this->createExchangeRateTable($fetchedExchangeRateTable);
        }

        return $exchangeRateTableCollection;
    }
}