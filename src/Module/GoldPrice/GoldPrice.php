<?php
declare(strict_types=1);

namespace NBPFetch\Module\GoldPrice;

use InvalidArgumentException;
use NBPFetch\Module\AbstractModule;
use NBPFetch\Module\GoldPrice\Parser\Parser;
use NBPFetch\Module\GoldPrice\Structure;
use NBPFetch\Module\GoldPrice\Structure\GoldPriceCollection;
use NBPFetch\Fetcher\Fetcher;
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
class GoldPrice extends AbstractModule
{
    /**
     * @var string API_SUBSET API Subset that returns gold price data.
     */
    private const API_SUBSET = "cenyzlota";

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
     * Returns current gold price.
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function current(): Structure\GoldPrice
    {
        $parsedResponse = $this->get(true);
        $parsedResponse = $parsedResponse[0];

        return $parsedResponse;
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
        return $this->get(true, new PathElement("last"), new Count($count));
    }

    /**
     * Returns today's gold price.
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function today(): Structure\GoldPrice
    {
        $parsedResponse = $this->get(true, new PathElement("today"));
        $parsedResponse = $parsedResponse[0];

        return $parsedResponse;
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
        $parsedResponse = $this->get(false, new Date($date));
        $parsedResponse = $parsedResponse[0];

        return $parsedResponse;
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
        return $this->get(false, new Date($date_from), new Date($date_to));
    }
}
