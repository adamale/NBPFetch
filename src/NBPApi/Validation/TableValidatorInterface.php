<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\Validation;

use NBPFetch\NBPApi\Exception\InvalidTableException;

interface TableValidatorInterface
{
    /**
     * @param string $table
     * @return bool
     * @throws InvalidTableException
     */
    public function validate(string $table): bool;
}