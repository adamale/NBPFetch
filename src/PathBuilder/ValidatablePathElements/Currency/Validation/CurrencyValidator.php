<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Currency\Validation;

use NBPFetch\Exception\InvalidCurrencyException;

/**
 * Class CurrencyValidator
 * @package NBPFetch\Validation
 */
class CurrencyValidator implements CurrencyValidatorInterface
{
    /**
     * @var int CURRENCY_CODE_LENGTH Required currency code length.
     */
    private const CURRENCY_CODE_LENGTH = 3;

    /**
     * Validates that provided currency is allowed.
     * @param string $currency
     * @return bool
     * @throws InvalidCurrencyException
     */
    public function validate(string $currency): bool
    {
        if (!$this->validateCurrencyIsAllLetters($currency)) {
            throw new InvalidCurrencyException("Currency must consists only of letters");
        } elseif (!$this->validateCurrencyHasProperLength($currency)) {
            throw new InvalidCurrencyException(
                sprintf(
                    "Currency must be %s characters long",
                    self::CURRENCY_CODE_LENGTH
                )
            );
        }

        return true;
    }

    private function validateCurrencyIsAllLetters(string $currency): bool
    {
        return ctype_alpha($currency);
    }

    private function validateCurrencyHasProperLength(string $currency): bool
    {
        return mb_strlen($currency) === self::CURRENCY_CODE_LENGTH;
    }
}
