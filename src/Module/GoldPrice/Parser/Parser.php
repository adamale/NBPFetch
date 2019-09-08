<?php
declare(strict_types=1);

namespace NBPFetch\Module\GoldPrice\Parser;

use NBPFetch\Module\GoldPrice\Structure\GoldPrice;
use NBPFetch\Module\GoldPrice\Structure\GoldPriceCollection;
use NBPFetch\Parser\ParserInterface;

/**
 * Class Parser
 * @package NBPFetch\Module\GoldPrice\Parser
 */
class Parser implements ParserInterface
{
    /**
     * Creates a gold price collection from fetched array.
     * @param array $fetchedGoldPrices
     * @return GoldPriceCollection
     */
    public function parse(array $fetchedGoldPrices): GoldPriceCollection
    {
        $goldPriceCollection = new GoldPriceCollection();
        foreach ($fetchedGoldPrices as $fetchedGoldPrice) {
            $goldPriceCollection[] = $this->parseGoldPrice($fetchedGoldPrice);
        }

        return $goldPriceCollection;
    }

    /**
     * @param array $fetchedGoldPrice
     * @return GoldPrice
     */
    private function parseGoldPrice(array $fetchedGoldPrice): GoldPrice
    {
        return new GoldPrice(
            (string) $fetchedGoldPrice["data"],
            (string) $fetchedGoldPrice["cena"]
        );
    }
}
