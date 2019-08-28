<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use NBPFetch\Validation\CountValidatorInterface;
use NBPFetch\Validation\CurrencyValidatorInterface;
use NBPFetch\Validation\DateValidatorInterface;
use NBPFetch\Validation\TableValidatorInterface;

/**
 * Class Validator
 * @package NBPFetch\CurrencyRate
 */
class Validator implements ValidatorInterface
{
    /**
     * @var CountValidatorInterface
     */
    private $countValidator;

    /**
     * @var CurrencyValidatorInterface
     */
    private $currencyValidator;

    /**
     * @var DateValidatorInterface
     */
    private $dateValidator;

    /**
     * @var TableValidatorInterface
     */
    private $tableValidator;

    /**
     * Validator constructor.
     * @param CountValidatorInterface $countValidator
     * @param CurrencyValidatorInterface $currencyValidator
     * @param DateValidatorInterface $dateValidator
     * @param TableValidatorInterface $tableValidator
     */
    public function __construct(
        CountValidatorInterface $countValidator,
        CurrencyValidatorInterface $currencyValidator,
        DateValidatorInterface $dateValidator,
        TableValidatorInterface $tableValidator
    ) {
        $this->countValidator = $countValidator;
        $this->currencyValidator = $currencyValidator;
        $this->dateValidator = $dateValidator;
        $this->tableValidator = $tableValidator;
    }

    /**
     * @return CountValidatorInterface
     */
    public function getCountValidator(): CountValidatorInterface
    {
        return $this->countValidator;
    }

    /**
     * @return CurrencyValidatorInterface
     */
    public function getCurrencyValidator(): CurrencyValidatorInterface
    {
        return $this->currencyValidator;
    }

    /**
     * @return DateValidatorInterface
     */
    public function getDateValidator(): DateValidatorInterface
    {
        return $this->dateValidator;
    }

    /**
     * @return TableValidatorInterface
     */
    public function getTableValidator():TableValidatorInterface
    {
        return $this->tableValidator;
    }
}
