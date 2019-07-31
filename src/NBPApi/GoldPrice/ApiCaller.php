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
     * @var string API_SUBSET API Subset that returns gold price data.
     */
    private const API_SUBSET = "cenyzlota/";

    /**
     * Returns a single gold price from given URL.
     * @param string $path
     * @return GoldPrice|null
     */
    public function getSingle(string $path): ?GoldPrice
    {
        $fetchedGoldPrices = $this->getNBPApi()->fetch(self::API_SUBSET . $path);
        return $this->createGoldPriceFromFetchedArray($fetchedGoldPrices[0]);
    }

    /**
     * Returns a set of gold prices from given URL.
     * @param string $path
     * @return GoldPriceCollection
     * @throws InvalidResponseException
     */
    public function getCollection(string $path): ?GoldPriceCollection
    {
        $fetchedGoldPrices = $this->getNBPApi()->fetch(self::API_SUBSET . $path);
        return $this->createGoldPriceCollection($fetchedGoldPrices);
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