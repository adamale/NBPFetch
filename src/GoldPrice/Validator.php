<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice;

use NBPFetch\Validation\CountValidatorInterface;
use NBPFetch\Validation\DateValidatorInterface;

/**
 * Class Validator
 * @package NBPFetch\ExchangeRateTable
 */
class Validator implements ValidatorInterface
{
    /**
     * @var CountValidatorInterface
     */
    private $countValidator;

    /**
     * @var DateValidatorInterface
     */
    private $dateValidator;

    /**
     * Validator constructor.
     * @param CountValidatorInterface $countValidator
     * @param DateValidatorInterface $dateValidator
     */
    public function __construct(
        CountValidatorInterface $countValidator,
        DateValidatorInterface $dateValidator
    ) {
        $this->countValidator = $countValidator;
        $this->dateValidator = $dateValidator;
    }

    /**
     * @return CountValidatorInterface
     */
    public function getCountValidator(): CountValidatorInterface
    {
        return $this->countValidator;
    }

    /**
     * @return DateValidatorInterface
     */
    public function getDateValidator(): DateValidatorInterface
    {
        return $this->dateValidator;
    }
}