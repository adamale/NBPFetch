<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Table\Validation;

use NBPFetch\Exception\InvalidTableException;

/**
 * Interface TableValidatorInterface
 * @package NBPFetch\Validation
 */
interface TableValidatorInterface
{
    /**
     * @param string $table
     * @return bool
     * @throws InvalidTableException
     */
    public function validate(string $table): bool;
}
