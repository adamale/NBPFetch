<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable;

use NBPFetch\Validation\CountValidatorInterface;
use NBPFetch\Validation\DateValidatorInterface;
use NBPFetch\Validation\TableValidatorInterface;

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
     * @var TableValidatorInterface
     */
    private $tableValidator;

    /**
     * Validator constructor.
     * @param CountValidatorInterface $countValidator
     * @param DateValidatorInterface $dateValidator
     * @param TableValidatorInterface $tableValidator
     */
    public function __construct(
        CountValidatorInterface $countValidator,
        DateValidatorInterface $dateValidator,
        TableValidatorInterface $tableValidator
    ) {
        $this->countValidator = $countValidator;
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
