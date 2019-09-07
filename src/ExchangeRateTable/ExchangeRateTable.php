<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use InvalidArgumentException;
use NBPFetch\ExchangeRateTable\Parser\Parser;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateTableCollection;
use NBPFetch\Fetcher\Fetcher;
use NBPFetch\PathBuilder\PathBuilder;
use NBPFetch\PathBuilder\PathElement;
use NBPFetch\PathBuilder\ValidatablePathElements\Count\Count;
use NBPFetch\PathBuilder\ValidatablePathElements\Date\Date;
use NBPFetch\PathBuilder\ValidatablePathElements\Table\Table;
use Psr\Cache\CacheItemPoolInterface;
use UnexpectedValueException;

/**
 * Class ExchangeRateTable
 * @package NBPFetch\ExchangeRateTable
 */
class ExchangeRateTable
{
    /**
     * @var string API_SUBSET API Subset that returns exchange rate table data.
     */
    private const API_SUBSET = "exchangerates/tables";

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
     * @param CacheItemPoolInterface|null $cache
     */
    public function __construct(string $table, CacheItemPoolInterface $cache = null)
    {
        $this->pathBuilder = new PathBuilder();
        $this->fetcher = new Fetcher($cache);
        $this->parser = new Parser();

        $this->pathBuilder->addElement(new PathElement(self::API_SUBSET));
        $this->pathBuilder->addElement(new Table($table));
    }

    /**
     * Returns a single exchange rate table from NBP API.
     * @param bool $inconstantResponse
     * @param PathElement ...$pathElements
     * @return Structure\ExchangeRateTable
     */
    private function getSingle(bool $inconstantResponse, PathElement ...$pathElements): Structure\ExchangeRateTable
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
     * Returns a set of exchange rate tables from NBP API.
     * @param bool $inconstantResponse
     * @param PathElement ...$pathElements
     * @return ExchangeRateTableCollection
     */
    private function getCollection(bool $inconstantResponse, PathElement ...$pathElements): ExchangeRateTableCollection
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
     * Returns current exchange rate table.
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function current(): Structure\ExchangeRateTable
    {
        return $this->getSingle(true);
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
        return $this->getCollection(true, new PathElement("last"), new Count($count));
    }

    /**
     * Returns today's exchange rate table.
     * @return Structure\ExchangeRateTable
     * @throws UnexpectedValueException
     */
    public function today(): Structure\ExchangeRateTable
    {
        return $this->getSingle(true, new PathElement("today"));
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
        return $this->getSingle(false, new Date($date));
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
        return $this->getCollection(false, new Date($date_from), new Date($date_to));
    }
}
