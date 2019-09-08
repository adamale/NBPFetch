<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder;

/**
 * Class PathSegment
 * @package NBPFetch\PathBuilder
 */
class PathSegment
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * PathSegment constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
