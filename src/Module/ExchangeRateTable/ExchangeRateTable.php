<?php
declare(strict_types=1);

namespace NBPFetch\Module\ExchangeRateTable;

use InvalidArgumentException;
use NBPFetch\Module\AbstractModule;
use NBPFetch\Module\ExchangeRateTable\Parser\Parser;
use NBPFetch\Module\ExchangeRateTable\Structure;
use NBPFetch\Module\ExchangeRateTable\Structure\ExchangeRateTableCollection;
use NBPFetch\Fetcher\Fetcher;
use NBPFetch\PathBuilder\PathBuilder;
use NBPFetch\PathBuilder\PathSegment;
use NBPFetch\PathBuilder\ValidatablePathSegments\Count\Count;
use NBPFetch\PathBuilder\ValidatablePathSegments\Date\Date;
use NBPFetch\PathBuilder\ValidatablePathSegments\Table\Table;
use Psr\Cache\CacheItemPoolInterface;
use UnexpectedValueException;

/**
 * Class ExchangeRateTable
 * @package NBPFetch\ExchangeRateTable
 */
class ExchangeRateTable extends AbstractModule
{
    /**
     * @var string API_SUBSET API Subset that returns exchange rate table data.
     */
    private const API_SUBSET = "exchangerates/tables";

    /**
     * ExchangeRateTable constructor.
     * @param string $table Table type.
     * @param CacheItemPoolInterface|null $cache
     * @throws InvalidArgumentException
     */
    public function __construct(string $table, CacheItemPoolInterface $cache = null)
    {
        $this->pathBuilder = new PathBuilder();
        $this->fetcher = new Fetcher($cache);
        $this->parser = new Parser();

        $this->pathBuilder->addSegment(new PathSegment(self::API_SUBSET));
        $this->pathBuilder->addSegment(new Table($table));
    }

    /**
     * Returns current exchange rate table.
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function current(): Structure\ExchangeRateTable
    {
        $parsedResponse = $this->get(true);
        $parsedResponse = $parsedResponse[0];

        return $parsedResponse;
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
        return $this->get(true, new PathSegment("last"), new Count($count));
    }

    /**
     * Returns today's exchange rate table.
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function today(): Structure\ExchangeRateTable
    {
        $parsedResponse = $this->get(true, new PathSegment("today"));
        $parsedResponse = $parsedResponse[0];

        return $parsedResponse;
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
        $parsedResponse = $this->get(false, new Date($date));
        $parsedResponse = $parsedResponse[0];

        return $parsedResponse;
    }

    /**
     * Returns a set of exchange rate tables between given dates.
     * @param string $date_from Date in Y-m-d format.
     * @param string $date_to Date in Y-m-d format.
     * @return ExchangeRateTableCollection
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDateRange(string $date_from, string $date_to): ExchangeRateTableCollection
    {
        return $this->get(false, new Date($date_from), new Date($date_to));
    }
}
