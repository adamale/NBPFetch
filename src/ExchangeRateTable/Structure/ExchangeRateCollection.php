<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable\Structure;

use ObjectCollection\Collection;

/**
 * Class CurrencyRateCollection
 * @package NBPFetch\ExchangeRateTable\Structure
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
