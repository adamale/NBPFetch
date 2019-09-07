<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Currency;

use NBPFetch\PathBuilder\ValidatablePathElements\AbstractValidatablePathElement;
use NBPFetch\PathBuilder\ValidatablePathElements\Currency\Validation\CurrencyValidator;
use NBPFetch\PathBuilder\ValidatablePathElements\Currency\Validation\CurrencyValidatorInterface;

/**
 * Class Currency
 * @package NBPFetch\PathBuilder\Structure
 */
class Currency extends AbstractValidatablePathElement
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
