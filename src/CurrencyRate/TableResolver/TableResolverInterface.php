<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate\TableResolver;

use NBPFetch\Exception\InvalidCurrencyException;

/**
 * Interface TableResolverInterface
 * @package NBPFetch\CurrencyRate\TableResolver
 */
interface TableResolverInterface
{
    /**
     * @param string $currency
     * @return string
     * @throws InvalidCurrencyException
     */
    public function resolve(string $currency): string;
}
