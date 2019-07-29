<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\GoldPrice;

use NBPFetch\NBPApi\Fetcher\AbstractFetcher;
use NBPFetch\Structure\GoldPrice\GoldPrice;
use NBPFetch\Structure\GoldPrice\GoldPriceCollection;

/**
 * Class Fetcher
 * @package NBPFetch\NBPApi\GoldPrice
 */
class Fetcher extends AbstractFetcher
{
    /**
     * Returns current gold price.
     * @return GoldPrice|null
     */
    public function current(): ?GoldPrice
    {
        return $this->apiCaller->getSingle("");
    }

    /**
     * Returns a set of n last gold prices.
     * @param int $count Should be an positive integer.
     * @return GoldPriceCollection|null
     */
    public function last(int $count): ?GoldPriceCollection
    {
        return $this->apiCaller->getCollection("last/" . ((string) $count) . "/");
    }

    /**
     * Returns today gold price.
     * @return GoldPrice|null
     */
    public function today(): ?GoldPrice
    {
        return $this->apiCaller->getSingle("today/");
    }

    /**
     * Returns a given date gold price.
     * @param string $date Date in YYYY-MM-DD format.
     * @return GoldPrice|null
     */
    public function byDate(string $date): ?GoldPrice
    {
        return $this->apiCaller->getSingle($date . "/");
    }

    /**
     * Returns a set of gold prices between given dates.
     * @param string $from  Date in YYYY-MM-DD format.
     * @param string $to    Date in YYYY-MM-DD format.
     * @return GoldPriceCollection|null
     */
    public function byDateRange(string $from, string $to): ?GoldPriceCollection
    {
        return $this->apiCaller->getCollection($from . "/" . $to);
    }
}