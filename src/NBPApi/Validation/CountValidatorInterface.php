<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\Validation;

use NBPFetch\NBPApi\Exception\invalidCountException;

interface CountValidatorInterface
{
    /**
     * @param int $count
     * @return bool
     * @throws invalidCountException
     */
    public function validate(int $count): bool;
}