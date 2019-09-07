<?php
declare(strict_types=1);

namespace NBPFetch\Module\CurrencyRate\TableResolver;

use InvalidArgumentException;

/**
 * Interface TableResolverInterface
 * @package NBPFetch\Module\CurrencyRate\TableResolver
 */
interface TableResolverInterface
{
    /**
     * @param string $currency
     * @return string
     * @throws InvalidArgumentException
     */
    public function resolve(string $currency): string;
}
