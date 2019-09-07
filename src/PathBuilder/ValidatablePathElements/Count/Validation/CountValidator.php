<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Count\Validation;

use InvalidArgumentException;

/**
 * Class CountValidator
 * @package NBPFetch\Validation
 */
class CountValidator implements CountValidatorInterface
{
    /**
     * @var int MINIMAL_COUNT Minimal supported count for fetched sets.
     */
    private const MINIMAL_COUNT = 1;

    /**
     * Validates that provided count is equal or greater than minimal count.
     * @param int $count
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(int $count): bool
    {
        if ($count < self::MINIMAL_COUNT) {
            throw new InvalidArgumentException(
                sprintf("Count must not be lower than %s", self::MINIMAL_COUNT)
            );
        }

        return true;
    }
}
