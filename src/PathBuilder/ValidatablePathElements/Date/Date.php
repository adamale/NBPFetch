<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Date;

use NBPFetch\PathBuilder\ValidatablePathElements\AbstractValidatablePathElement;
use NBPFetch\PathBuilder\ValidatablePathElements\Date\Validation\DateValidator;
use NBPFetch\PathBuilder\ValidatablePathElements\Date\Validation\DateValidatorInterface;

/**
 * Class Date
 * @package NBPFetch\PathBuilder\Structure
 */
class Date extends AbstractValidatablePathElement
{
    /**
     * Date constructor.
     * @param string $value
     * @param DateValidatorInterface|null $dateValidator
     */
    public function __construct(string $value, ?DateValidatorInterface $dateValidator = null)
    {
        parent::__construct($value);
        $this->validator = $dateValidator ?? new DateValidator();
    }
}
