<?php
declare(strict_types=1);

namespace NBPFetch\Structure\GoldPrice;

use NBPFetch\Structure\Collection\Collection;

/**
 * Class GoldPriceCollection
 * @package NBPFetch\Structure\GoldPrice
 */
class GoldPriceCollection extends Collection
{
    /**
     * Adds an GoldPrice item to the collection.
     * @param GoldPrice $item
     * @return void
     */
    public function add($item): void
    {
        if ($item instanceof GoldPrice) {
            $this->insert($item);
        }
    }
}