<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice;

use NBPFetch\Validation\CountValidatorInterface;
use NBPFetch\Validation\DateValidatorInterface;

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
}
