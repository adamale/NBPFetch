<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use InvalidArgumentException;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\Exception\InvalidTableException;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRate;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateCollection;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateTableCollection;
use NBPFetch\NBPApi\NBPApi;
use NBPFetch\Validation\CountValidator;
use NBPFetch\Validation\DateValidator;
use NBPFetch\Validation\TableValidator;
use UnexpectedValueException;

/**
 * Class ExchangeRateTable
 * @package NBPFetch\ExchangeRateTable
 */
class ExchangeRateTable
{
    /**
     * @var string API_SUBSET API Subset that returns exchange rate table data.
     */
    private const API_SUBSET = "exchangerates/tables/";

    /**
     * @var string
     */
    private $table;

    /**
     * @var NBPApi
     */
    private $NBPApi;

    /**
     * ExchangeRateTable constructor.
     * @param string $table Table type.
     * @throws InvalidArgumentException
     */
    public function __construct(string $table) {
        try {
            $tableValidator = new TableValidator();
            $tableValidator->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $this->table = $table;
        $this->NBPApi = new NBPApi();
    }

    /**
     * Returns a single exchange rate table from NBP API.
     * @param string $methodPath
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function getSingle(string $methodPath): Structure\ExchangeRateTable
    {
        $path = $this->createURLPath($methodPath);
        $responseArray = $this->NBPApi->fetch($path);
        return $this->parse($responseArray[0]);
    }

    /**
     * Returns a set of exchange rate tables from NBP API.
     * @param string $methodPath
     * @return ExchangeRateTableCollection
     * @throws UnexpectedValueException
     */
    public function getCollection(string $methodPath): ExchangeRateTableCollection
    {
        $path = $this->createURLPath($methodPath);
        $responseArray = $this->NBPApi->fetch($path);
        return $this->parseCollection($responseArray);
    }

    /**
     * @param string $methodPath
     * @return string
     */
    private function createURLPath(string $methodPath): string
    {
        $currencyPath = sprintf("%s/%s", self::API_SUBSET, $this->table);
        if (mb_strlen($methodPath) > 0) {
            $path = sprintf("%s/%s", $currencyPath, $methodPath);
        } else {
            $path = $currencyPath;
        }

        return $path;
    }

    /**
     * Creates an exchange rate table from fetched array.
     * @param array $fetchedExchangeRateTable
     * @return Structure\ExchangeRateTable
     */
    private function parse(array $fetchedExchangeRateTable): Structure\ExchangeRateTable
    {
        $exchangeRateCollection = new ExchangeRateCollection();
        foreach ($fetchedExchangeRateTable["rates"] as $exchangeRate) {
            $exchangeRateCollection[] = new ExchangeRate($exchangeRate["code"], (string) $exchangeRate["mid"]);
        }

        return new Structure\ExchangeRateTable(
            $fetchedExchangeRateTable["table"],
            $fetchedExchangeRateTable["no"],
            $fetchedExchangeRateTable["effectiveDate"],
            $exchangeRateCollection
        );
    }

    /**
     * Creates an exchange rate table collection from fetched array.
     * @param array $fetchedExchangeRateTables
     * @return ExchangeRateTableCollection
     */
    private function parseCollection(array $fetchedExchangeRateTables): ExchangeRateTableCollection
    {
        $exchangeRateTableCollection = new ExchangeRateTableCollection();
        foreach ($fetchedExchangeRateTables as $fetchedExchangeRateTable) {
            $exchangeRateTableCollection[] = $this->parse($fetchedExchangeRateTable);
        }

        return $exchangeRateTableCollection;
    }

    /**
     * Returns current exchange rate table.
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function current(): Structure\ExchangeRateTable
    {
        $path = sprintf("");

        return $this->getSingle($path);
    }

    /**
     * Returns a set of n last exchange rate tables.
     * @param int $count Must be an positive integer.
     * @return ExchangeRateTableCollection
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function last(int $count): ExchangeRateTableCollection
    {
        try {
            $countValidator = new CountValidator();
            $countValidator->validate($count);
        } catch (InvalidCountException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("last/%s", $count);

        return $this->getCollection($path);
    }

    /**
     * Returns today's exchange rate table.
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function today(): Structure\ExchangeRateTable
    {
        $path = sprintf("today");

        return $this->getSingle($path);
    }

    /**
     * Returns a given date exchange rate table.
     * @param string $date Date in Y-m-d format.
     * @return Structure\ExchangeRateTable
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDate(string $date): Structure\ExchangeRateTable
    {
        try {
            $dateValidator = new DateValidator();
            $dateValidator->validate($date);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s", $date);

        return $this->getSingle($path);
    }

    /**
     * Returns a set of exchange rate tables between given dates.
     * @param string $from Date in Y-m-d format.
     * @param string $to Date in Y-m-d format.
     * @return ExchangeRateTableCollection
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDateRange(string $from, string $to): ExchangeRateTableCollection
    {
        try {
            $dateValidator = new DateValidator();
            $dateValidator->validate($from);
            $dateValidator->validate($to);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s", $from, $to);

        return $this->getCollection($path);
    }
}
