<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\GoldPrice;

use NBPFetch\NBPApi\ApiCaller\AbstractApiCaller;
use NBPFetch\NBPApi\Exception\InvalidResponseException;
use NBPFetch\Structure\GoldPrice\GoldPrice;
use NBPFetch\Structure\GoldPrice\GoldPriceCollection;

/**
 * Class ApiCaller
 * @package NBPFetch\NBPApi\GoldPrice
 */
class ApiCaller extends AbstractApiCaller
{
    /**
     * @var string API_SUBSET API subset that returns gold price data.
     */
    private const API_SUBSET = "cenyzlota/";

    /**
     * @var string DATE_FORMAT Supported date format.
     */
    private const DATE_FORMAT = "Y-m-d";

    /**
     * Returns a single gold price from given URL.
     * @param string $url
     * @return GoldPrice|null
     */
    public function getSingle(string $url): ?GoldPrice
    {
        $fetchedGoldPrices = $this->fetch(self::API_SUBSET . $url);
        return $this->createGoldPriceFromFetchedArray($fetchedGoldPrices[0]);
    }

    /**
     * Returns a set of gold prices from given URL.
     * @param string $url
     * @return GoldPriceCollection
     * @throws InvalidResponseException
     */
    public function getCollection(string $url): ?GoldPriceCollection
    {
        $fetchedGoldPrices = $this->fetch(self::API_SUBSET . $url);
        return $this->createGoldPriceCollection($fetchedGoldPrices);
    }

    /**
     * Returns an API error.
     * @return string
     */
    public function getDateFormat(): string
    {
        return self::DATE_FORMAT;
    }

    /**
     * Creates a GoldPrice object from fetched array.
     * @param array $fetchedGoldPrice
     * @return GoldPrice
     */
    private function createGoldPriceFromFetchedArray(array $fetchedGoldPrice): GoldPrice
    {
        return new GoldPrice(
            (string) $fetchedGoldPrice["data"],
            (string) $fetchedGoldPrice["cena"]
        );
    }

    /**
     * Creates a GoldPriceCollection object from fetched array.
     * @param array $fetchedGoldPrices
     * @return GoldPriceCollection
     */
    private function createGoldPriceCollection(array $fetchedGoldPrices): GoldPriceCollection
    {
        $goldPriceCollection = new GoldPriceCollection();
        foreach ($fetchedGoldPrices as $fetchedGoldPrice) {
            $goldPriceCollection->add(
                $this->createGoldPriceFromFetchedArray($fetchedGoldPrice)
            );
        }

        return $goldPriceCollection;
    }
}