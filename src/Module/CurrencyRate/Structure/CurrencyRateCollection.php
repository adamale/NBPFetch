<?php
declare(strict_types=1);

namespace NBPFetch\Module\CurrencyRate\Structure;

use ObjectCollection\Collection;

/**
 * Class CurrencyRateCollection
 * @package NBPFetch\Module\CurrencyRate\Structure
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
