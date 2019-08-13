<?php
declare(strict_types=1);

namespace NBPFetch\Structure\ExchangeRate;

use NBPFetch\Structure\Collection\Collection;

/**
 * Class ExchangeRateTableCollection
 * @package NBPFetch\Structure\ExchangeRate
 */
class ExchangeRateTableCollection extends Collection
{
    /**
     * Adds an ExchangeRateTable item to the collection.
     * @param ExchangeRateTable $item
     * @return void
     */
    public function add($item): void
    {
        if ($item instanceof ExchangeRateTable) {
            $this->insert($item);
        }
    }
}