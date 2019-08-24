<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use InvalidArgumentException;
use NBPFetch\ApiCaller\ApiCallerInterface;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\Exception\InvalidTableException;
use UnexpectedValueException;

/**
 * Class Fetcher
 * @package NBPFetch\NBPApi\ExchangeRateTable
 */
class Fetcher
{
    /**
     * @var ApiCallerInterface
     */
    private $apiCaller;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ApiCallerInterface $apiCaller
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ApiCallerInterface $apiCaller,
        ValidatorInterface $validator
    ) {
        $this->apiCaller = $apiCaller;
        $this->validator = $validator;
    }

    /**
     * Returns current exchange rate table.
     * @param string $table Table type.
     * @return ExchangeRateTable|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function current(string $table): ?ExchangeRateTable
    {
        try {
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/", $table);

        return $this->apiCaller->getSingle($path);
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
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        try {
            $this->validator->getCountValidator()->validate($count);
        } catch (InvalidCountException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/last/%s", $table, $count);

        return $this->apiCaller->getCollection($path);
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
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/today/", $table);

        return $this->apiCaller->getSingle($path);
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
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        try {
            $this->validator->getDateValidator()->validate($date);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/", $table, $date);

        return $this->apiCaller->getSingle($path);
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
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        try {
            $this->validator->getDateValidator()->validate($from);
            $this->validator->getDateValidator()->validate($to);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/%s", $table, $from, $to);

        return $this->apiCaller->getCollection($path);
    }
}