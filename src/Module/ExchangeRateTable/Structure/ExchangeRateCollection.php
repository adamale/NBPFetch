<?php
declare(strict_types=1);

namespace NBPFetch\Module\ExchangeRateTable\Structure;

use ObjectCollection\Collection;

/**
 * Class ExchangeRateCollection
 * @package NBPFetch\Module\ExchangeRateTable\Structure
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
