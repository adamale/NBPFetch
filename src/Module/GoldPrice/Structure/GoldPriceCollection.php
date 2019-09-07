<?php
declare(strict_types=1);

namespace NBPFetch\Module\GoldPrice\Structure;

use ObjectCollection\Collection;

/**
 * Class GoldPriceCollection
 * @package NBPFetch\Module\GoldPrice\Structure
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
