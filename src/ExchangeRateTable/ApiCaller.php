<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use NBPFetch\ApiCaller\AbstractApiCallerSingleOrCollection;
use UnexpectedValueException;

/**
 * Class ApiCaller
 * @package NBPFetch\ExchangeRateTable
 */
class ApiCaller extends AbstractApiCallerSingleOrCollection
{
    /**
     * @var string API_SUBSET API Subset that returns exchange rate table data.
     */
    private const API_SUBSET = "exchangerates/tables/";

    /**
     * Returns a single exchange rate table from given URL.
     * @param string $path
     * @return ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function getSingle(string $path): ExchangeRateTable
    {
        $fetchedExchangeRateTables = $this->getFromNBPAPI(self::API_SUBSET . $path);
        return $this->createExchangeRateTable($fetchedExchangeRateTables[0]);
    }

    /**
     * Returns a set of exchange rate tables from given URL.
     * @param string $path
     * @return ExchangeRateTableCollection
     * @throws UnexpectedValueException
     */
    public function getCollection(string $path): ExchangeRateTableCollection
    {
        $fetchedExchangeRateTables = $this->getFromNBPAPI(self::API_SUBSET . $path);
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
