<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathSegments\Count;

use NBPFetch\PathBuilder\ValidatablePathSegments\AbstractValidatablePathSegment;
use NBPFetch\PathBuilder\ValidatablePathSegments\Count\Validation\CountValidator;
use NBPFetch\PathBuilder\ValidatablePathSegments\Count\Validation\CountValidatorInterface;

/**
 * Class Count
 * @package NBPFetch\PathBuilder\Structure
 */
class Count extends AbstractValidatablePathSegment
{
    /**
     * Count constructor.
     * @param int $value
     * @param CountValidatorInterface|null $countValidator
     */
    public function __construct(int $value, ?CountValidatorInterface $countValidator = null)
    {
        parent::__construct($value);
        $this->validator = $countValidator ?? new CountValidator();
    }
}
