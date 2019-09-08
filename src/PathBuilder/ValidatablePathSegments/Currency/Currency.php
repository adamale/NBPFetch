<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathSegments\Currency;

use NBPFetch\PathBuilder\ValidatablePathSegments\AbstractValidatablePathSegment;
use NBPFetch\PathBuilder\ValidatablePathSegments\Currency\Validation\CurrencyValidator;
use NBPFetch\PathBuilder\ValidatablePathSegments\Currency\Validation\CurrencyValidatorInterface;

/**
 * Class Currency
 * @package NBPFetch\PathBuilder\Structure
 */
class Currency extends AbstractValidatablePathSegment
{
    /**
     * Currency constructor.
     * @param string $value
     * @param CurrencyValidatorInterface|null $currencyValidator
     */
    public function __construct(string $value, ?CurrencyValidatorInterface $currencyValidator = null)
    {
        parent::__construct($value);
        $this->validator = $currencyValidator ?? new CurrencyValidator();
    }
}
