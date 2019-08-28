<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use ObjectCollection\Collection;

/**
 * Class CurrencyRateCollection
 * @package NBPFetch\ExchangeRateTable
 */
class ExchangeRateCollection extends Collection
{
    /**
     * ExchangeRateCollection constructor.
     */
    public function __construct()
    {
        $this->allowed_item = ExchangeRate::class;
    }
}
