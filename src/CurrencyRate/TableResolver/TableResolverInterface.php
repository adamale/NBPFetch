<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate\TableResolver;

use InvalidArgumentException;

/**
 * Interface TableResolverInterface
 * @package NBPFetch\CurrencyRate\TableResolver
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
