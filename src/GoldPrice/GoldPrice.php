<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice;

use InvalidArgumentException;
use NBPFetch\GoldPrice\Parser\Parser;
use NBPFetch\GoldPrice\Structure\GoldPriceCollection;
use NBPFetch\Fetcher\Fetcher;
use NBPFetch\GoldPrice\Structure;
use NBPFetch\PathBuilder\PathBuilder;
use NBPFetch\PathBuilder\PathElement;
use NBPFetch\PathBuilder\ValidatablePathElements\Count\Count;
use NBPFetch\PathBuilder\ValidatablePathElements\Date\Date;
use Psr\Cache\CacheItemPoolInterface;
use UnexpectedValueException;

/**
 * Class GoldPrice
 * @package NBPFetch\GoldPrice
 */
class GoldPrice
{
    /**
     * @var string API_SUBSET API Subset that returns gold price data.
     */
    private const API_SUBSET = "cenyzlota";

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
     * @param CacheItemPoolInterface|null $cache
     */
    public function __construct(CacheItemPoolInterface $cache = null)
    {
        $this->pathBuilder = new PathBuilder();
        $this->fetcher = new Fetcher($cache);
        $this->parser = new Parser();

        $this->pathBuilder->addElement(new PathElement(self::API_SUBSET));
    }

    /**
     * Returns a single gold price from NBP API.
     * @param bool $inconstantResponse
     * @param PathElement ...$pathElements
     * @return Structure\GoldPrice
     * @throws InvalidArgumentException
     */
    private function getSingle(bool $inconstantResponse, PathElement ...$pathElements): Structure\GoldPrice
    {
        if (!empty($pathElements)) {
            foreach ($pathElements as $pathElement) {
                $this->pathBuilder->addElement($pathElement);
            }
        }

        $path = $this->pathBuilder->build();
        $responseArray = $this->fetcher->fetch($path, $inconstantResponse);
        return $this->parser->parse($responseArray[0]);
    }

    /**
     * Returns a set of gold prices from NBP API.
     * @param bool $inconstantResponse
     * @param PathElement ...$pathElements
     * @return GoldPriceCollection
     * @throws InvalidArgumentException
     */
    private function getCollection(bool $inconstantResponse, PathElement ...$pathElements): GoldPriceCollection
    {
        if (!empty($pathElements)) {
            foreach ($pathElements as $pathElement) {
                $this->pathBuilder->addElement($pathElement);
            }
        }

        $path = $this->pathBuilder->build();
        $responseArray = $this->fetcher->fetch($path, $inconstantResponse);
        return $this->parser->parseCollection($responseArray);
    }

    /**
     * Returns current gold price.
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function current(): Structure\GoldPrice
    {
        return $this->getSingle(true);
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
        return $this->getCollection(true, new PathElement("last"), new Count($count));
    }

    /**
     * Returns today's gold price.
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function today(): Structure\GoldPrice
    {
        return $this->getSingle(true, new PathElement("today"));
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
        return $this->getSingle(false, new Date($date));
    }

    /**
     * Returns a set of gold prices between given dates.
     * @param string $date_from Date in Y-m-d format.
     * @param string $date_to Date in Y-m-d format.
     * @return GoldPriceCollection
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDateRange(string $date_from, string $date_to): GoldPriceCollection
    {
        return $this->getCollection(false, new Date($date_from), new Date($date_to));
    }
}
