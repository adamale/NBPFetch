<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Table;

use NBPFetch\PathBuilder\ValidatablePathElements\AbstractValidatablePathElement;
use NBPFetch\PathBuilder\ValidatablePathElements\Table\Validation\TableValidator;
use NBPFetch\PathBuilder\ValidatablePathElements\Table\Validation\TableValidatorInterface;

/**
 * Class Table
 * @package NBPFetch\PathBuilder\Structure
 */
class Table extends AbstractValidatablePathElement
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
