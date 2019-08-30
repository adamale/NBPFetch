<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice;

use InvalidArgumentException;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidDateException;
use NBPFetch\GoldPrice\Structure\GoldPriceCollection;
use NBPFetch\NBPApi\NBPApi;
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
     * @var string API_SUBSET API Subset that returns gold price data.
     */
    private const API_SUBSET = "cenyzlota/";

    /**
     * @var NBPApi
     */
    private $NBPApi;

    /**
     * GoldPrice constructor.
     */
    public function __construct()
    {
        $this->NBPApi = new NBPApi();
    }

    /**
     * Returns a single gold price from NBP API.
     * @param string $methodPath
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function getSingle(string $methodPath): Structure\GoldPrice
    {
        $path = $this->createURLPath($methodPath);
        $responseArray = $this->NBPApi->fetch($path);
        return $this->parse($responseArray[0]);
    }

    /**
     * Returns a set of gold prices from NBP API.
     * @param string $methodPath
     * @return GoldPriceCollection
     * @throws UnexpectedValueException
     */
    public function getCollection(string $methodPath): GoldPriceCollection
    {
        $path = $this->createURLPath($methodPath);
        $responseArray = $this->NBPApi->fetch($path);
        return $this->parseCollection($responseArray);
    }

    /**
     * @param string $methodPath
     * @return string
     */
    private function createURLPath(string $methodPath): string
    {
        $goldPricePath = sprintf("%s", self::API_SUBSET);
        if (mb_strlen($methodPath) > 0) {
            $path = sprintf("%s/%s", $goldPricePath, $methodPath);
        } else {
            $path = $goldPricePath;
        }

        return $path;
    }

    /**
     * Creates a gold price from fetched array.
     * @param array $fetchedGoldPrice
     * @return Structure\GoldPrice
     */
    private function parse(array $fetchedGoldPrice): Structure\GoldPrice
    {
        return new Structure\GoldPrice(
            (string) $fetchedGoldPrice["data"],
            (string) $fetchedGoldPrice["cena"]
        );
    }

    /**
     * Creates gold price collection from fetched array.
     * @param array $fetchedGoldPrices
     * @return GoldPriceCollection
     */
    private function parseCollection(array $fetchedGoldPrices): GoldPriceCollection
    {
        $goldPriceCollection = new GoldPriceCollection();
        foreach ($fetchedGoldPrices as $fetchedGoldPrice) {
            $goldPriceCollection[] = $this->parse($fetchedGoldPrice);
        }

        return $goldPriceCollection;
    }

    /**
     * Returns current gold price.
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function current(): Structure\GoldPrice
    {
        $path = sprintf("");

        return $this->getSingle($path);
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

        $path = sprintf("last/%s", $count);

        return $this->getCollection($path);
    }

    /**
     * Returns today's gold price.
     * @return Structure\GoldPrice
     * @throws UnexpectedValueException
     */
    public function today(): Structure\GoldPrice
    {
        $path = sprintf("today");

        return $this->getSingle($path);
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

        $path = sprintf("%s", $date);

        return $this->getSingle($path);
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

        $path = sprintf("%s/%s", $from, $to);

        return $this->getCollection($path);
    }
}
