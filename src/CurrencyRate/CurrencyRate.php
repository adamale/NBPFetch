<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use InvalidArgumentException;
use NBPFetch\CurrencyRate\PathBuilder\PathBuilder;
use NBPFetch\CurrencyRate\Parser\Parser;
use NBPFetch\CurrencyRate\Structure\CurrencyRateSeries;
use NBPFetch\CurrencyRate\TableResolver\TableResolver;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidCurrencyException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\Exception\InvalidTableException;
use NBPFetch\Fetcher\Fetcher;
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
     * @var PathBuilder
     */
    private $pathBuilder;

    /**
     * @var Fetcher
     */
    private $fetcher;

    /**
     * @var Parser
     */
    private $parser;

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

        $this->pathBuilder = new PathBuilder($table, $currency);
        $this->fetcher = new Fetcher();
        $this->parser = new Parser();
    }

    /**
     * Returns parsed data from NBP API.
     * @param string ...$methodPathElements
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    private function get(string ...$methodPathElements): CurrencyRateSeries
    {
        $path = $this->pathBuilder->build(...$methodPathElements);
        $responseArray = $this->fetcher->fetch($path);
        return $this->parser->parse($responseArray);
    }

    /**
     * Returns current currency rate.
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    public function current(): CurrencyRateSeries
    {
        return $this->get();
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

        return $this->get("last", (string) $count);
    }

    /**
     * Returns today's currency rate.
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    public function today(): CurrencyRateSeries
    {
        return $this->get("today");
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

        return $this->get($date);
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

        return $this->get($from, $to);
    }
}
