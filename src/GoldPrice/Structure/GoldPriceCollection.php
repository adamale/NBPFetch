<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice\Structure;

use ObjectCollection\Collection;

/**
 * Class GoldPriceCollection
 * @package NBPFetch\Structure\GoldPrice\Structure
 */
class GoldPriceCollection extends Collection
{
    /**
     * GoldPriceCollection constructor.
     */
    public function __construct()
    {
        $this->allowed_item = GoldPrice::class;
    }
}
