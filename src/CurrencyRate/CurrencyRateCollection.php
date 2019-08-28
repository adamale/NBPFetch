<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use ObjectCollection\Collection;

/**
 * Class CurrencyRateCollection
 * @package NBPFetch\CurrencyRate
 */
class CurrencyRateCollection extends Collection
{
    /**
     * CurrencyRateCollection constructor.
     */
    public function __construct()
    {
        $this->allowed_item = CurrencyRate::class;
    }
}
