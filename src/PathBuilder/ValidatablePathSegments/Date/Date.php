<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathSegments\Date;

use NBPFetch\PathBuilder\ValidatablePathSegments\AbstractValidatablePathSegment;
use NBPFetch\PathBuilder\ValidatablePathSegments\Date\Validation\DateValidator;
use NBPFetch\PathBuilder\ValidatablePathSegments\Date\Validation\DateValidatorInterface;

/**
 * Class Date
 * @package NBPFetch\PathBuilder\Structure
 */
class Date extends AbstractValidatablePathSegment
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
