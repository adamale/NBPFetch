<?php
declare(strict_types=1);

namespace NBPFetch\Module\CurrencyRate;

use InvalidArgumentException;
use NBPFetch\Module\AbstractModule;
use NBPFetch\Module\CurrencyRate\Parser\Parser;
use NBPFetch\Module\CurrencyRate\Structure\CurrencyRateSeries;
use NBPFetch\Module\CurrencyRate\TableResolver\TableResolver;
use NBPFetch\CurrencyTable\CurrencyTableA;
use NBPFetch\CurrencyTable\CurrencyTableB;
use NBPFetch\CurrencyTable\CurrencyTableCollection;
use NBPFetch\Fetcher\Fetcher;
use NBPFetch\PathBuilder\PathBuilder;
use NBPFetch\PathBuilder\PathSegment;
use NBPFetch\PathBuilder\ValidatablePathSegments\Count\Count;
use NBPFetch\PathBuilder\ValidatablePathSegments\Currency\Currency;
use NBPFetch\PathBuilder\ValidatablePathSegments\Date\Date;
use NBPFetch\PathBuilder\ValidatablePathSegments\Table\Table;
use Psr\Cache\CacheItemPoolInterface;
use UnexpectedValueException;

/**
 * Class CurrencyRate
 * @package NBPFetch\CurrencyRate
 */
class CurrencyRate extends AbstractModule
{
    /**
     * @var string API_SUBSET API Subset that returns currency rate data.
     */
    private const API_SUBSET = "exchangerates/rates";

    /**
     * CurrencyRate constructor.
     * @param string $currency ISO 4217 currency code.
     * @param CacheItemPoolInterface|null $cache
     * @throws InvalidArgumentException
     */
    public function __construct(string $currency, CacheItemPoolInterface $cache = null)
    {
        $this->pathBuilder = new PathBuilder();
        $this->fetcher = new Fetcher($cache);
        $this->parser = new Parser();

        $currencyTableCollection = new CurrencyTableCollection();
        $currencyTableCollection[] = new CurrencyTableA();
        $currencyTableCollection[] = new CurrencyTableB();
        $tableResolver = new TableResolver($currencyTableCollection);
        $table = $tableResolver->resolve($currency);

        $this->pathBuilder->addSegment(new PathSegment(self::API_SUBSET));
        $this->pathBuilder->addSegment(new Table($table));
        $this->pathBuilder->addSegment(new Currency($currency));
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
        return $this->get(true, new PathSegment("last"), new Count($count));
    }

    /**
     * Returns today's currency rate.
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    public function today(): CurrencyRateSeries
    {
        return $this->get(true, new PathSegment("today"));
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
