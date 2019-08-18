<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\GoldPrice;

use InvalidArgumentException;
use NBPFetch\NBPApi\Exception\InvalidCountException;
use NBPFetch\NBPApi\Exception\InvalidDateException;
use NBPFetch\NBPApi\Fetcher\AbstractFetcher;
use NBPFetch\Structure\GoldPrice\GoldPrice;
use NBPFetch\Structure\GoldPrice\GoldPriceCollection;
use UnexpectedValueException;

/**
 * Class Fetcher
 * @package NBPFetch\NBPApi\GoldPrice
 */
class Fetcher extends AbstractFetcher
{
    /**
     * Returns current gold price.
     * @return GoldPrice|null
     * @throws UnexpectedValueException
     */
    public function current(): ?GoldPrice
    {
        return $this->getApiCaller()->getSingle("");
    }

    /**
     * Returns a set of n last gold prices.
     * @param int $count Must be an positive integer.
     * @return GoldPriceCollection|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function last(int $count): ?GoldPriceCollection
    {
        try {
            $this->getCountValidator()->validateCount($count);
        } catch (InvalidCountException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("last/%s", $count);

        return $this->getApiCaller()->getCollection($path);
    }

    /**
     * Returns today gold price.
     * @return GoldPrice|null
     * @throws UnexpectedValueException
     */
    public function today(): ?GoldPrice
    {
        return $this->getApiCaller()->getSingle("today/");
    }

    /**
     * Returns a given date gold price.
     * @param string $date Date in Y-m-d format.
     * @return GoldPrice|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDate(string $date): ?GoldPrice
    {
        try {
            $this->getDateValidator()->validateDateFormat($date);
            $this->getDateValidator()->validateDate($date);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/", $date);

        return $this->getApiCaller()->getSingle($path);
    }

    /**
     * Returns a set of gold prices between given dates.
     * @param string $from  Date in Y-m-d format.
     * @param string $to    Date in Y-m-d format.
     * @return GoldPriceCollection|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDateRange(string $from, string $to): ?GoldPriceCollection
    {
        try {
            $this->getDateValidator()->validateDateFormat([$from, $to]);
            $this->getDateValidator()->validateDate([$from, $to]);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s", $from, $to);

        return $this->getApiCaller()->getCollection($path);
    }
}