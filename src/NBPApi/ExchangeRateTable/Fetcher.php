<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\ExchangeRateTable;

use InvalidArgumentException;
use NBPFetch\NBPApi\Exception\InvalidCountException;
use NBPFetch\NBPApi\Exception\InvalidDateException;
use NBPFetch\NBPApi\Exception\InvalidTableException;
use NBPFetch\NBPApi\Fetcher\AbstractFetcher;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTable;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTableCollection;
use UnexpectedValueException;

/**
 * Class Fetcher
 * @package NBPFetch\NBPApi\ExchangeRateTable
 */
class Fetcher extends AbstractFetcher
{
    /**
     * Returns current exchange rate table.
     * @param string $table Table type.
     * @return ExchangeRateTable|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function current(string $table): ?ExchangeRateTable
    {
        try {
            $this->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/", $table);

        return $this->getApiCaller()->getSingle($path);
    }

    /**
     * Returns a set of n last exchange rate tables.
     * @param string $table Table type.
     * @param int $count Must be an positive integer.
     * @return ExchangeRateTableCollection|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function last(string $table, int $count): ?ExchangeRateTableCollection
    {
        try {
            $this->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        try {
            $this->getCountValidator()->validateCount($count);
        } catch (InvalidCountException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/last/%s", $table, $count);

        return $this->getApiCaller()->getCollection($path);
    }

    /**
     * Returns today exchange rate table.
     * @param string $table Table type.
     * @return ExchangeRateTable|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function today(string $table): ?ExchangeRateTable
    {
        try {
            $this->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/today/", $table);

        return $this->getApiCaller()->getSingle($path);
    }

    /**
     * Returns a given date exchange rate table.
     * @param string $table Table type.
     * @param string $date Date in Y-m-d format.
     * @return ExchangeRateTable|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDate(string $table, string $date): ?ExchangeRateTable
    {
        try {
            $this->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        try {
            $this->getDateValidator()->validateDateFormat($date);
            $this->getDateValidator()->validateDate($date);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/", $table, $date);

        return $this->getApiCaller()->getSingle($path);
    }

    /**
     * Returns a set of exchange rate tables between given dates.
     * @param string $table Table type.
     * @param string $from Date in Y-m-d format.
     * @param string $to Date in Y-m-d format.
     * @return ExchangeRateTableCollection|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDateRange(string $table, string $from, string $to): ?ExchangeRateTableCollection
    {
        try {
            $this->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        try {
            $this->getDateValidator()->validateDateFormat([$from, $to]);
            $this->getDateValidator()->validateDate([$from, $to]);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/%s", $table, $from, $to);

        return $this->getApiCaller()->getCollection($path);
    }
}