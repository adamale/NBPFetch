<?php
declare(strict_types=1);

namespace NBPFetch\Validation;

use NBPFetch\Exception\invalidCountException;

interface CountValidatorInterface
{
    /**
     * @param int $count
     * @return bool
     * @throws invalidCountException
     */
    public function validate(int $count): bool;
}