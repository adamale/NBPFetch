<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements\Table\Validation;

use InvalidArgumentException;

/**
 * Class TableValidator
 * @package NBPFetch\Validation
 */
class TableValidator implements TableValidatorInterface
{
    /**
     * @var string[]
     */
    protected const ALLOWED_TABLES = ["A", "B"];

    /**
     * @param string $table
     * @return bool
     */
    public function validate(string $table): bool
    {
        $table = mb_strtoupper($table);

        if (!in_array($table, self::ALLOWED_TABLES)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Table must be one of the following: %s",
                    implode(", ", self::ALLOWED_TABLES)
                )
            );
        }

        return true;
    }
}
