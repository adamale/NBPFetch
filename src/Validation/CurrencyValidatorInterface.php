<?php
declare(strict_types=1);

namespace NBPFetch\Validation;

use NBPFetch\Exception\InvalidCurrencyException;

interface CurrencyValidatorInterface
{
    /**
     * @param string $currency
     * @return bool
     * @throws InvalidCurrencyException
     */
    public function validate(string $currency): bool;
}
