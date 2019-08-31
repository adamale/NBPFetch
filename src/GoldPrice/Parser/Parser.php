<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice\Parser;

use NBPFetch\GoldPrice\Structure\GoldPrice;
use NBPFetch\GoldPrice\Structure\GoldPriceCollection;

/**
 * Class Parser
 * @package NBPFetch\GoldPrice\Parser
 */
class Parser
{
    /**
     * Creates a gold price from fetched array.
     * @param array $fetchedGoldPrice
     * @return GoldPrice
     */
    public function parse(array $fetchedGoldPrice): GoldPrice
    {
        return new GoldPrice(
            (string) $fetchedGoldPrice["data"],
            (string) $fetchedGoldPrice["cena"]
        );
    }

    /**
     * Creates gold price collection from fetched array.
     * @param array $fetchedGoldPrices
     * @return GoldPriceCollection
     */
    public function parseCollection(array $fetchedGoldPrices): GoldPriceCollection
    {
        $goldPriceCollection = new GoldPriceCollection();
        foreach ($fetchedGoldPrices as $fetchedGoldPrice) {
            $goldPriceCollection[] = $this->parse($fetchedGoldPrice);
        }

        return $goldPriceCollection;
    }
}
