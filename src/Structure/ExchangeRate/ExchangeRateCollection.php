<?php
declare(strict_types=1);

namespace NBPFetch\Structure\ExchangeRate;

use NBPFetch\Structure\Collection\Collection;

/**
 * Class ExchangeRateCollection
 * @package NBPFetch\Structure\ExchangeRate
 */
class ExchangeRateCollection extends Collection
{
    /**
     * Adds an ExchangeRate item to the collection.
     * @param ExchangeRate $item
     * @return void
     */
    public function add($item): void
    {
        if ($item instanceof ExchangeRate) {
            $this->insert($item);
        }
    }
}