<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyTable;

use ObjectCollection\Collection;

/**
 * Class CurrencyTableCollection
 * @package NBPFetch\CurrencyTable
 */
class CurrencyTableCollection extends Collection
{
    /**
     * CurrencyTableCollection constructor.
     */
    public function __construct()
    {
        $this->allowed_item = AbstractCurrencyTable::class;
    }
}
