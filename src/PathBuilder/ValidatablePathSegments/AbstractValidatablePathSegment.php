<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder\ValidatablePathSegments;

use NBPFetch\PathBuilder\PathSegment;

/**
 * Class AbstractValidatablePathSegment
 * @package NBPFetch\PathBuilder
 */
abstract class AbstractValidatablePathSegment extends PathSegment
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
