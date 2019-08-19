<?php
declare(strict_types=1);

namespace NBPFetch\Validation;

use NBPFetch\Exception\InvalidTableException;

interface TableValidatorInterface
{
    /**
     * @param string $table
     * @return bool
     * @throws InvalidTableException
     */
    public function validate(string $table): bool;
}