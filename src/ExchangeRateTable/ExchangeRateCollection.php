<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use ObjectCollection\Collection;

/**
 * Class ExchangeRateCollection
 * @package NBPFetch\ExchangeRateTable
 */
class ExchangeRateCollection extends Collection
{
    public function __construct()
    {
        $this->allowed_item = ExchangeRate::class;
    }
}