<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use NBPFetch\Validation\CountValidatorInterface;
use NBPFetch\Validation\DateValidatorInterface;
use NBPFetch\Validation\TableValidatorInterface;

/**
 * interface ValidatorInterface
 * @package NBPFetch\ExchangeRateTable
 */
interface ValidatorInterface
{
    /**
     * @return CountValidatorInterface
     */
    public function getCountValidator(): CountValidatorInterface;

    /**
     * @return DateValidatorInterface
     */
    public function getDateValidator(): DateValidatorInterface;

    /**
     * @return TableValidatorInterface
     */
    public function getTableValidator(): TableValidatorInterface;
}