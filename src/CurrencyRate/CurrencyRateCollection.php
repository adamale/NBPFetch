<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use ObjectCollection\Collection;

class CurrencyRateCollection extends Collection
{
    public function __construct()
    {
        $this->allowed_item = CurrencyRate::class;
    }
}
