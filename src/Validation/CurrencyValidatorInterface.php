<?php
declare(strict_types=1);

namespace NBPFetch\Validation;

use NBPFetch\Exception\InvalidCurrencyException;

/**
 * Interface CurrencyValidatorInterface
 * @package NBPFetch\Validation
 */
interface CurrencyValidatorInterface
{
    /**
     * @param string $currency
     * @return bool
     * @throws InvalidCurrencyException
     */
    public function validate(string $currency): bool;
}
