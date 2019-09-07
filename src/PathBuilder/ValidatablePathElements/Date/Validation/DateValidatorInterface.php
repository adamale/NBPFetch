<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Date\Validation;

use NBPFetch\Exception\InvalidDateException;

/**
 * Interface DateValidatorInterface
 * @package NBPFetch\Validation
 */
interface DateValidatorInterface
{
    /**
     * @param string $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validate(string $date): bool;
}
