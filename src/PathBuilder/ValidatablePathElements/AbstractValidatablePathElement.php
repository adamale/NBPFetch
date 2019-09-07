<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathElements;

use NBPFetch\PathBuilder\PathElement;

/**
 * Class AbstractValidatablePathElement
 * @package NBPFetch\PathBuilder
 */
abstract class AbstractValidatablePathElement extends PathElement
{
    /**
     * @var mixed
     */
    protected $validator;

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return $this->validator->validate($this->value);
    }
}
