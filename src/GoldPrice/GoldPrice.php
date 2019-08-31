<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice;

use InvalidArgumentException;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\GoldPrice\Parser\Parser;
use NBPFetch\GoldPrice\PathBuilder\PathBuilder;
use NBPFetch\GoldPrice\Structure\GoldPriceCollection;
use NBPFetch\Fetcher\Fetcher;
use NBPFetch\GoldPrice\Structure;
use NBPFetch\Validation\CountValidator;
use NBPFetch\Validation\DateValidator;
use UnexpectedValueException;

/**
 * Class GoldPrice
 * @package NBPFetch\GoldPrice
 */
class GoldPrice
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
     * GoldPrice constructor.
     */
    public function __construct()
    {
        $this->pathBuilder = new PathBuilder();
        $this->fetcher = new Fetcher();
        $this->parser = new Parser();
    }

    /**
     * Returns a single gold price from NBP API.
     * @param string ...$methodPathElements
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function getSingle(string ...$methodPathElements): Structure\GoldPrice
    {
        $path = $this->pathBuilder->build(...$methodPathElements);
        $responseArray = $this->fetcher->fetch($path);
        return $this->parser->parse($responseArray[0]);
    }

    /**
     * Returns a set of gold prices from NBP API.
     * @param string ...$methodPathElements
     * @return GoldPriceCollection
     * @throws UnexpectedValueException
     */
    public function getCollection(string ...$methodPathElements): GoldPriceCollection
    {
        $path = $this->pathBuilder->build(...$methodPathElements);
        $responseArray = $this->fetcher->fetch($path);
        return $this->parser->parseCollection($responseArray);
    }

    /**
     * Returns current gold price.
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function current(): Structure\GoldPrice
    {
        return $this->getSingle();
    }

    /**
     * Returns a set of n last gold prices.
     * @param int $count Must be an positive integer.
     * @return GoldPriceCollection
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function last(int $count): GoldPriceCollection
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
     * Returns today's gold price.
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function today(): Structure\GoldPrice
    {
        return $this->getSingle("today");
    }

    /**
     * Returns a given date gold price.
     * @param string $date Date in Y-m-d format.
     * @return Structure\GoldPrice
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDate(string $date): Structure\GoldPrice
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
     * Returns a set of gold prices between given dates.
     * @param string $from Date in Y-m-d format.
     * @param string $to Date in Y-m-d format.
     * @return GoldPriceCollection
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDateRange(string $from, string $to): GoldPriceCollection
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
