<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Currency\Validation;

use InvalidArgumentException;

/**
 * Interface CurrencyValidatorInterface
 * @package NBPFetch\Validation
 */
interface CurrencyValidatorInterface
{
    /**
     * @param string $currency
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(string $currency): bool;
}
