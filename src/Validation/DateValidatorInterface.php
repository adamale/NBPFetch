<?php
declare(strict_types=1);

namespace NBPFetch\Validation;

use NBPFetch\Exception\InvalidDateException;

interface DateValidatorInterface
{
    /**
     * @param string $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validate(string $date): bool;
}
