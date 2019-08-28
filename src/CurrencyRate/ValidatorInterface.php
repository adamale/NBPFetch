<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use NBPFetch\Validation\CountValidatorInterface;
use NBPFetch\Validation\CurrencyValidatorInterface;
use NBPFetch\Validation\DateValidatorInterface;
use NBPFetch\Validation\TableValidatorInterface;

/**
 * interface ValidatorInterface
 * @package NBPFetch\CurrencyRate
 */
interface ValidatorInterface
{
    /**
     * @return CountValidatorInterface
     */
    public function getCountValidator(): CountValidatorInterface;
    /**
     * @return CurrencyValidatorInterface
     */
    public function getCurrencyValidator(): CurrencyValidatorInterface;

    /**
     * @return DateValidatorInterface
     */
    public function getDateValidator(): DateValidatorInterface;

    /**
     * @return TableValidatorInterface
     */
    public function getTableValidator(): TableValidatorInterface;
}
