<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Count\Validation;

use NBPFetch\Exception\InvalidCountException;

/**
 * Interface CountValidatorInterface
 * @package NBPFetch\Validation
 */
interface CountValidatorInterface
{
    /**
     * @param int $count
     * @return bool
     * @throws invalidCountException
     */
    public function validate(int $count): bool;
}
