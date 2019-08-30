<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use InvalidArgumentException;
use NBPFetch\CurrencyRate\Structure\CurrencyRateCollection;
use NBPFetch\CurrencyRate\Structure\CurrencyRateSeries;
use NBPFetch\CurrencyRate\TableResolver\TableResolver;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidCurrencyException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\Exception\InvalidTableException;
use NBPFetch\NBPApi\NBPApi;
use NBPFetch\Validation\CountValidator;
use NBPFetch\Validation\CurrencyValidator;
use NBPFetch\Validation\DateValidator;
use NBPFetch\Validation\TableValidator;
use UnexpectedValueException;

/**
 * Class CurrencyRate
 * @package NBPFetch\CurrencyRate
 */
class CurrencyRate
{
    /**
     * @var string API_SUBSET API Subset that returns currency rate data.
     */
    private const API_SUBSET = "exchangerates/rates/";

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string|null
     */
    private $table;

    /**
     * @var NBPApi
     */
    private $NBPApi;

    /**
     * CurrencyRate constructor.
     * @param string $currency ISO 4217 currency code.
     * @param string|null $table Table type.
     * @throws InvalidArgumentException
     */
    public function __construct(string $currency, ?string $table = null)
    {
        try {
            $currencyValidator = new CurrencyValidator();
            $tableValidator = new TableValidator();
            $tableResolver = new TableResolver();
            $currencyValidator->validate($currency);
            $table = $table ?? $tableResolver->resolve($currency);
            $tableValidator->validate($table);
        } catch (InvalidCurrencyException|InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $this->currency = $currency;
        $this->table = $table;
        $this->NBPApi = new NBPApi();
    }

    /**
     * Returns parsed data from NBP API.
     * @param string $methodPath
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    private function get(string $methodPath): CurrencyRateSeries
    {
        $path = $this->createURLPath($methodPath);
        $responseArray = $this->NBPApi->fetch($path);
        return $this->parse($responseArray);
    }

    /**
     * @param string $methodPath
     * @return string
     */
    private function createURLPath(string $methodPath): string
    {
        $currencyPath = sprintf("%s/%s/%s", self::API_SUBSET, $this->table, $this->currency);
        if (mb_strlen($methodPath) > 0) {
            $path = sprintf("%s/%s", $currencyPath, $methodPath);
        } else {
            $path = $currencyPath;
        }

        return $path;
    }

    /**
     * Creates a currency rate series from fetched array.
     * @param array $fetchedCurrencyRateSeries
     * @return CurrencyRateSeries
     */
    private function parse(array $fetchedCurrencyRateSeries): CurrencyRateSeries
    {
        $rateCollection = new CurrencyRateCollection();
        foreach ($fetchedCurrencyRateSeries["rates"] as $rate) {
            $rateCollection[] = new Structure\CurrencyRate(
                $rate["no"],
                $rate["effectiveDate"],
                (string) $rate["mid"]
            );
        }

        return new CurrencyRateSeries(
            $fetchedCurrencyRateSeries["table"],
            $fetchedCurrencyRateSeries["currency"],
            $fetchedCurrencyRateSeries["code"],
            $rateCollection
        );
    }

    /**
     * Returns current currency rate.
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    public function current(): CurrencyRateSeries
    {
        $path = sprintf("");

        return $this->get($path);
    }

    /**
     * Returns a set of n last currency rates.
     * @param int $count Must be an positive integer.
     * @return CurrencyRateSeries
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function last(int $count): CurrencyRateSeries
    {
        try {
            $countValidator = new CountValidator();
            $countValidator->validate($count);
        } catch (InvalidCountException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("last/%s", $count);

        return $this->get($path);
    }

    /**
     * Returns today's exchange rate table.
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    public function today(): CurrencyRateSeries
    {
        $path = sprintf("today");

        return $this->get($path);
    }

    /**
     * Returns a given currency rate.
     * @param string $date Date in Y-m-d format.
     * @return CurrencyRateSeries
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDate(string $date): CurrencyRateSeries
    {
        try {
            $dateValidator = new DateValidator();
            $dateValidator->validate($date);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s", $date);

        return $this->get($path);
    }

    /**
     * Returns a set of currency rates between given dates.
     * @param string $from Date in Y-m-d format.
     * @param string $to Date in Y-m-d format.
     * @return CurrencyRateSeries
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDateRange(string $from, string $to): CurrencyRateSeries
    {
        try {
            $dateValidator = new DateValidator();
            $dateValidator->validate($from);
            $dateValidator->validate($to);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s", $from, $to);

        return $this->get($path);
    }
}
