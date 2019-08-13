<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\ExchangeRateTable;

use NBPFetch\NBPApi\ApiCaller\AbstractApiCaller;
use NBPFetch\NBPApi\Exception\InvalidResponseException;
use NBPFetch\Structure\ExchangeRate\ExchangeRate;
use NBPFetch\Structure\ExchangeRate\ExchangeRateCollection;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTable;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTableCollection;

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
     * @throws InvalidResponseException
     */
    public function getSingle(string $path): ?ExchangeRateTable
    {
        $fetchedExchangeRateTables = $this->getNBPApi()->fetch(self::API_SUBSET . $path);
        return $this->createExchangeRateTableFromFetchedArray($fetchedExchangeRateTables[0]);
    }

    /**
     * Returns a set of exchange rate tables from given URL.
     * @param string $path
     * @return ExchangeRateTableCollection
     * @throws InvalidResponseException
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
    private function createExchangeRateTableFromFetchedArray(array $fetchedExchangeRateTable): ExchangeRateTable
    {
        $exchangeRateCollection = new ExchangeRateCollection();
        foreach ($fetchedExchangeRateTable["rates"] as $exchangeRate) {
            $exchangeRateCollection->add(
                new ExchangeRate($exchangeRate["code"], (string) $exchangeRate["mid"])
            );
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
            $exchangeRateTableCollection->add(
                $this->createExchangeRateTableFromFetchedArray($fetchedExchangeRateTable)
            );
        }

        return $exchangeRateTableCollection;
    }
}