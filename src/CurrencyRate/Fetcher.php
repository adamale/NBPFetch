<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use InvalidArgumentException;
use NBPFetch\ApiCaller\ApiCallerSingleInterface;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidCurrencyException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\Exception\InvalidTableException;
use UnexpectedValueException;

/**
 * Class Fetcher
 * @package NBPFetch\CurrencyRate
 */
class Fetcher
{
    /**
     * @var ApiCallerSingleInterface
     */
    private $apiCaller;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var TableResolverInterface
     */
    private $tableResolver;

    /**
     * @param ApiCallerSingleInterface $apiCaller
     * @param ValidatorInterface $validator
     * @param TableResolverInterface $tableResolver
     */
    public function __construct(
        ApiCallerSingleInterface $apiCaller,
        ValidatorInterface $validator,
        TableResolverInterface $tableResolver
    ) {
        $this->apiCaller = $apiCaller;
        $this->validator = $validator;
        $this->tableResolver = $tableResolver;
    }

    /**
     * Returns current currency rate.
     * @param string $currency ISO 4217 currency code.
     * @param string|null $table Table type.
     * @return CurrencyRateSeries
     */
    public function current(string $currency, ?string $table = null): CurrencyRateSeries
    {
        try {
            $this->validator->getCurrencyValidator()->validate($currency);
            $table = $table ?? $this->tableResolver->resolve($currency);
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidCurrencyException|InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s", $table, $currency);

        return $this->apiCaller->get($path);
    }

    /**
     * Returns a set of n last currency rates.
     * @param string $currency ISO 4217 currency code.
     * @param int $count Must be an positive integer.
     * @param string|null $table Table type.
     * @return CurrencyRateSeries
     */
    public function last(string $currency, int $count, ?string $table = null): CurrencyRateSeries
    {
        try {
            $this->validator->getCurrencyValidator()->validate($currency);
            $this->validator->getCountValidator()->validate($count);
            $table = $table ?? $this->tableResolver->resolve($currency);
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidCurrencyException|InvalidCountException|InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/last/%s", $table, $currency, $count);

        return $this->apiCaller->get($path);
    }

    /**
     * Returns today exchange rate table.
     * @param string $currency ISO 4217 currency code.
     * @param string|null $table Table type.
     * @return CurrencyRateSeries
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function today(string $currency, ?string $table = null): CurrencyRateSeries
    {
        try {
            $this->validator->getCurrencyValidator()->validate($currency);
            $table = $table ?? $this->tableResolver->resolve($currency);
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidCurrencyException|InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/today", $table, $currency);

        return $this->apiCaller->get($path);
    }

    /**
     * Returns a given date exchange rate table.
     * @param string $currency ISO 4217 currency code.
     * @param string $date Date in Y-m-d format.
     * @param string|null $table Table type.
     * @return CurrencyRateSeries
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDate(string $currency, string $date, ?string $table = null): CurrencyRateSeries
    {
        try {
            $this->validator->getCurrencyValidator()->validate($currency);
            $this->validator->getDateValidator()->validate($date);
            $table = $table ?? $this->tableResolver->resolve($currency);
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidCurrencyException|InvalidDateException|InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/%s", $table, $currency, $date);

        return $this->apiCaller->get($path);
    }

    /**
     * Returns a set of exchange rate tables between given dates.
     * @param string $currency ISO 4217 currency code.
     * @param string $from Date in Y-m-d format.
     * @param string $to Date in Y-m-d format.
     * @param string|null $table Table type.
     * @return CurrencyRateSeries
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDateRange(
        string $currency,
        string $from,
        string $to,
        ?string $table = null
    ): CurrencyRateSeries {
        try {
            $this->validator->getCurrencyValidator()->validate($currency);
            $this->validator->getDateValidator()->validate($from);
            $this->validator->getDateValidator()->validate($to);
            $table = $table ?? $this->tableResolver->resolve($currency);
            $this->validator->getTableValidator()->validate($table);
        } catch (InvalidCurrencyException|InvalidDateException|InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s/%s/%s", $table, $currency, $from, $to);

        return $this->apiCaller->get($path);
    }
}
