<?php
declare(strict_types=1);

namespace NBPFetch\Structure\GoldPrice;

use ObjectCollection\Collection;

/**
 * Class GoldPriceCollection
 * @package NBPFetch\Structure\GoldPrice
 */
class GoldPriceCollection extends Collection
{
    public function __construct()
    {
        $this->allowed_item = GoldPrice::class;
    }
}