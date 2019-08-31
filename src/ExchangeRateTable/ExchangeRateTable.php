<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use InvalidArgumentException;
use NBPFetch\ExchangeRateTable\Parser\Parser;
use NBPFetch\ExchangeRateTable\PathBuilder\PathBuilder;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\Exception\InvalidTableException;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateTableCollection;
use NBPFetch\Fetcher\Fetcher;
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
     * ExchangeRateTable constructor.
     * @param string $table Table type.
     * @throws InvalidArgumentException
     */
    public function __construct(string $table)
    {
        try {
            $tableValidator = new TableValidator();
            $tableValidator->validate($table);
        } catch (InvalidTableException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $this->pathBuilder = new PathBuilder($table);
        $this->fetcher = new Fetcher();
        $this->parser = new Parser();
    }

    /**
     * Returns a single exchange rate table from NBP API.
     * @param string ...$methodPathElements
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function getSingle(string ...$methodPathElements): Structure\ExchangeRateTable
    {
        $path = $this->pathBuilder->build(...$methodPathElements);
        $responseArray = $this->fetcher->fetch($path);
        return $this->parser->parse($responseArray[0]);
    }

    /**
     * Returns a set of exchange rate tables from NBP API.
     * @param string ...$methodPathElements
     * @return ExchangeRateTableCollection
     * @throws UnexpectedValueException
     */
    public function getCollection(string ...$methodPathElements): ExchangeRateTableCollection
    {
        $path = $this->pathBuilder->build(...$methodPathElements);
        $responseArray = $this->fetcher->fetch($path);
        return $this->parser->parseCollection($responseArray);
    }

    /**
     * Returns current exchange rate table.
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function current(): Structure\ExchangeRateTable
    {
        return $this->getSingle();
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

        return $this->getCollection("last", (string) $count);
    }

    /**
     * Returns today's exchange rate table.
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function today(): Structure\ExchangeRateTable
    {
        return $this->getSingle("today");
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

        return $this->getSingle($date);
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

        return $this->getCollection($from, $to);
    }
}
