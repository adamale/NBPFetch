<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable\Structure;

use ObjectCollection\Collection;

/**
 * Class ExchangeRateTableCollection
 * @package NBPFetch\ExchangeRateTable\Structure
 */
class ExchangeRateTableCollection extends Collection
{
    public function __construct()
    {
        $this->allowed_item = ExchangeRateTable::class;
    }
}
