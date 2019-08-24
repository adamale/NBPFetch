<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice;

use NBPFetch\ApiCaller\AbstractApiCaller;
use UnexpectedValueException;

/**
 * Class ApiCaller
 * @package NBPFetch\GoldPrice
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
     * @return GoldPrice
     * @throws UnexpectedValueException
     */
    public function getSingle(string $path): GoldPrice
    {
        $fetchedGoldPrices = $this->getNBPApi()->fetch(self::API_SUBSET . $path);
        return $this->createGoldPrice($fetchedGoldPrices[0]);
    }

    /**
     * Returns a set of gold prices from given URL.
     * @param string $path
     * @return GoldPriceCollection
     * @throws UnexpectedValueException
     */
    public function getCollection(string $path): GoldPriceCollection
    {
        $fetchedGoldPrices = $this->getNBPApi()->fetch(self::API_SUBSET . $path);
        return $this->createGoldPriceCollection($fetchedGoldPrices);
    }

    /**
     * Creates a GoldPrice object from fetched array.
     * @param array $fetchedGoldPrice
     * @return GoldPrice
     */
    private function createGoldPrice(array $fetchedGoldPrice): GoldPrice
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
            $goldPriceCollection[] = $this->createGoldPrice($fetchedGoldPrice);
        }

        return $goldPriceCollection;
    }
}