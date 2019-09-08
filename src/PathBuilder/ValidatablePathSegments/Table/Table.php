<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathSegments\Table;

use NBPFetch\PathBuilder\ValidatablePathSegments\AbstractValidatablePathSegment;
use NBPFetch\PathBuilder\ValidatablePathSegments\Table\Validation\TableValidator;
use NBPFetch\PathBuilder\ValidatablePathSegments\Table\Validation\TableValidatorInterface;

/**
 * Class Table
 * @package NBPFetch\PathBuilder\Structure
 */
class Table extends AbstractValidatablePathSegment
{
    /**
     * Table constructor.
     * @param string $value
     * @param TableValidatorInterface|null $tableValidator
     */
    public function __construct(string $value, ?TableValidatorInterface $tableValidator = null)
    {
        parent::__construct($value);
        $this->validator = $tableValidator ?? new TableValidator();
    }
}
