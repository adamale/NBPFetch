<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use NBPFetch\Exception\InvalidCurrencyException;

/**
 * Interface TableResolverInterface
 * @package NBPFetch\CurrencyRate
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
