<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathSegments\Table\Validation;

use InvalidArgumentException;

/**
 * Interface TableValidatorInterface
 * @package NBPFetch\Validation
 */
interface TableValidatorInterface
{
    /**
     * @param string $table
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate(string $table): bool;
}
