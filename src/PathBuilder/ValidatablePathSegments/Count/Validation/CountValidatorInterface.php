<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathSegments\Count\Validation;

use InvalidArgumentException;

/**
 * Interface CountValidatorInterface
 * @package NBPFetch\Validation
 */
interface CountValidatorInterface
{
    /**
     * @param int $count
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(int $count): bool;
}
