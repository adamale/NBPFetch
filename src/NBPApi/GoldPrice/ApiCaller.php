<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\GoldPrice;

use InvalidArgumentException;
use NBPFetch\NBPApi\ApiCaller\AbstractApiCaller;
use NBPFetch\Structure\GoldPrice\GoldPrice;
use NBPFetch\Structure\GoldPrice\GoldPriceCollection;

/**
 * Class ApiCaller
 * @package NBPFetch\NBPApi\GoldPrice
 */
class ApiCaller extends AbstractApiCaller
{
    /**
     * API subset that returns gold price data.
     * @var string
     */
    private const API_SUBSET = "cenyzlota/";

    /**
     * Returns a single gold price from given URL.
     * @param string $url
     * @return GoldPrice|null
     */
    public function getSingle(string $url): ?GoldPrice
    {
        try {
            $fetchedGoldPrices = $this->fetch(self::API_SUBSET . $url);
            return $this->createGoldPriceFromFetchedArray($fetchedGoldPrices[0]);
        } catch (InvalidArgumentException $e) {
            $this->setError($e->getMessage());
            return null;
        }
    }

    /**
     * Returns a set of gold prices from given URL.
     * @param string $url
     * @return GoldPriceCollection|null
     */
    public function getCollection(string $url): ?GoldPriceCollection
    {
        try {
            $fetchedGoldPrices = $this->fetch(self::API_SUBSET . $url);
            return $this->createGoldPriceCollection($fetchedGoldPrices);
        } catch (InvalidArgumentException $e) {
            $this->setError($e->getMessage());
            return null;
        }
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