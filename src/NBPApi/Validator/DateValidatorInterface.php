<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\Validator;

use NBPFetch\NBPApi\Exception\InvalidDateException;

interface DateValidatorInterface
{
    /**
     * @param string|array $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validateDateFormat($date): bool;

    /**
     * @param string|array $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validateDate($date): bool;
}