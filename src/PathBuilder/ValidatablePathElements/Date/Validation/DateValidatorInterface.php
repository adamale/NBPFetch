<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Date\Validation;

use InvalidArgumentException;

/**
 * Interface DateValidatorInterface
 * @package NBPFetch\Validation
 */
interface DateValidatorInterface
{
    /**
     * @param string $date
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(string $date): bool;
}
