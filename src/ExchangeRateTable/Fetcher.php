<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use InvalidArgumentException;
use NBPFetch\ApiCaller\ApiCallerSingleOrCollectionInterface;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\Exception\InvalidTableException;
use UnexpectedValueException;

/**
 * Class Fetcher
 * @package NBPFetch\ExchangeRateTable
 */
class Fetcher
{
    /**
     * @var ApiCallerSingleOrCollectionInterface
     */
    private $apiCaller;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ApiCallerSingleOrCollectionInterface $apiCaller
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ApiCallerSingleOrCollectionInterface $apiCaller,
        ValidatorInterface $validator
    ) {
        $this->apiCaller = $apiCaller;
        $this->validator = $validator;
    }

    /**
     * Returns current exchange rate table.
     * @param string $table Table type.
     * @return ExchangeRateTable
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function current(string $table): ExchangeRateTable
    {
        try {
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s", $table);

        return $this->apiCaller->getSingle($path);
    }

    /**
     * Returns a set of n last exchange rate tables.
     * @param string $table Table type.
     * @param int $count Must be an positive integer.
     * @return ExchangeRateTableCollection
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function last(string $table, int $count): ExchangeRateTableCollection
    {
        try {
            $this->validator->getTableValidator()->validate($table);
            $this->validator->getCountValidator()->validate($count);
        } catch (InvalidTableException|InvalidCountException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/last/%s", $table, $count);

        return $this->apiCaller->getCollection($path);
    }

    /**
     * Returns today's exchange rate table.
     * @param string $table Table type.
     * @return ExchangeRateTable
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function today(string $table): ExchangeRateTable
    {
        try {
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/today", $table);

        return $this->apiCaller->getSingle($path);
    }

    /**
     * Returns a given date exchange rate table.
     * @param string $table Table type.
     * @param string $date Date in Y-m-d format.
     * @return ExchangeRateTable
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDate(string $table, string $date): ExchangeRateTable
    {
        try {
            $this->validator->getTableValidator()->validate($table);
            $this->validator->getDateValidator()->validate($date);
        } catch (InvalidTableException|InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s", $table, $date);

        return $this->apiCaller->getSingle($path);
    }

    /**
     * Returns a set of exchange rate tables between given dates.
     * @param string $table Table type.
     * @param string $from Date in Y-m-d format.
     * @param string $to Date in Y-m-d format.
     * @return ExchangeRateTableCollection
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDateRange(string $table, string $from, string $to): ExchangeRateTableCollection
    {
        try {
            $this->validator->getTableValidator()->validate($table);
            $this->validator->getDateValidator()->validate($from);
            $this->validator->getDateValidator()->validate($to);
        } catch (InvalidTableException|InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/%s", $table, $from, $to);

        return $this->apiCaller->getCollection($path);
    }
}
