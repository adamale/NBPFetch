<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder;

/**
 * Class PathElement
 * @package NBPFetch\PathBuilder
 */
class PathElement
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * PathElement constructor.
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
