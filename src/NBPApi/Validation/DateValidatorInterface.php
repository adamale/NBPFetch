<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\Validation;

use NBPFetch\NBPApi\Exception\InvalidDateException;

interface DateValidatorInterface
{
    /**
     * @param string|array $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validateFormat($date): bool;

    /**
     * @param string|array $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validate($date): bool;
}