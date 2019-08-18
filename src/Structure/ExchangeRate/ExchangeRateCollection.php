<?php
declare(strict_types=1);

namespace NBPFetch\Structure\ExchangeRate;

use ObjectCollection\Collection;

/**
 * Class ExchangeRateCollection
 * @package NBPFetch\Structure\ExchangeRate
 */
class ExchangeRateCollection extends Collection
{
    public function __construct()
    {
        $this->allowed_item = ExchangeRate::class;
    }
}