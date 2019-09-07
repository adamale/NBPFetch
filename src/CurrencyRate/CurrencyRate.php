<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use InvalidArgumentException;
use NBPFetch\CurrencyRate\Parser\Parser;
use NBPFetch\CurrencyRate\Structure\CurrencyRateSeries;
use NBPFetch\CurrencyRate\TableResolver\TableResolver;
use NBPFetch\Fetcher\Fetcher;
use NBPFetch\PathBuilder\PathBuilder;
use NBPFetch\PathBuilder\PathElement;
use NBPFetch\PathBuilder\ValidatablePathElements\Count\Count;
use NBPFetch\PathBuilder\ValidatablePathElements\Currency\Currency;
use NBPFetch\PathBuilder\ValidatablePathElements\Date\Date;
use NBPFetch\PathBuilder\ValidatablePathElements\Table\Table;
use Psr\Cache\CacheItemPoolInterface;
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
    private const API_SUBSET = "exchangerates/rates";

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
     * @param CacheItemPoolInterface|null $cache
     */
    public function __construct(string $currency, CacheItemPoolInterface $cache = null)
    {
        $this->pathBuilder = new PathBuilder();
        $this->fetcher = new Fetcher($cache);
        $this->parser = new Parser();

        $tableResolver = new TableResolver();
        $table = $tableResolver->resolve($currency);

        $this->pathBuilder->addElement(new PathElement(self::API_SUBSET));
        $this->pathBuilder->addElement(new Table($table));
        $this->pathBuilder->addElement(new Currency($currency));
    }

    /**
     * Returns parsed data from NBP API.
     * @param bool $inconstantResponse
     * @param PathElement ...$pathElements
     * @return CurrencyRateSeries
     */
    private function get(bool $inconstantResponse, PathElement ...$pathElements): CurrencyRateSeries
    {
        if (!empty($pathElements)) {
            foreach ($pathElements as $pathElement) {
                $this->pathBuilder->addElement($pathElement);
            }
        }

        $path = $this->pathBuilder->build();
        $responseArray = $this->fetcher->fetch($path, $inconstantResponse);
        return $this->parser->parse($responseArray);
    }

    /**
     * Returns current currency rate.
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    public function current(): CurrencyRateSeries
    {
        return $this->get(true);
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
        return $this->get(true, new PathElement("last"), new Count($count));
    }

    /**
     * Returns today's currency rate.
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    public function today(): CurrencyRateSeries
    {
        return $this->get(true, new PathElement("today"));
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
        return $this->get(false, new Date($date));
    }

    /**
     * Returns a set of currency rates between given dates.
     * @param string $date_from Date in Y-m-d format.
     * @param string $date_to Date in Y-m-d format.
     * @return CurrencyRateSeries
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function byDateRange(string $date_from, string $date_to): CurrencyRateSeries
    {
        return $this->get(false, new Date($date_from), new Date($date_to));
    }
}
