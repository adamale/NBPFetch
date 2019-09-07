<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Count;

use NBPFetch\PathBuilder\ValidatablePathElements\AbstractValidatablePathElement;
use NBPFetch\PathBuilder\ValidatablePathElements\Count\Validation\CountValidator;
use NBPFetch\PathBuilder\ValidatablePathElements\Count\Validation\CountValidatorInterface;

/**
 * Class Count
 * @package NBPFetch\PathBuilder\Structure
 */
class Count extends AbstractValidatablePathElement
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
