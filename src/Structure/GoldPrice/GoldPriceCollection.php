<?php
declare(strict_types=1);

namespace NBPFetch\Structure\GoldPrice;

use NBPFetch\Structure\Collection\Collection;
use NBPFetch\Structure\Item\ItemInterface;

/**
 * Class GoldPriceCollection
 * @package NBPFetch\Structure\GoldPrice
 */
class GoldPriceCollection extends Collection
{
    /**
     * Adds an GoldPrice object to the collection.
     * @param ItemInterface $goldPrice
     * @return void
     */
    public function add(ItemInterface $goldPrice): void
    {
        if ($goldPrice instanceof GoldPrice) {
            $this->insert($goldPrice);
        }
    }
}