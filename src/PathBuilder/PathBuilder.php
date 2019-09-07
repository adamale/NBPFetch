<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder;

use Exception;
use InvalidArgumentException;
use NBPFetch\PathBuilder\ValidatablePathElements\AbstractValidatablePathElement;

/**
 * Class PathBuilder
 * @package NBPFetch\PathBuilder
 */
class PathBuilder
{
    /**
     * @var PathElement[]
     */
    private $pathElements;

    /**
     * @param PathElement $element
     */
    public function addElement(PathElement $element): void
    {
        if ($element instanceof AbstractValidatablePathElement) {
            try {
                $element->validate();
            } catch (Exception $e) {
                throw new InvalidArgumentException($e->getMessage());
            }
        }

        $this->pathElements[] = $element;
    }

    /**
     * @return string
     */
    public function build(): string
    {
        return sprintf(
            "%s",
            $this->buildSubPath()
        );
    }

    /**
     * Returns parsed data from NBP API.
     * @return string
     */
    private function buildSubPath(): string
    {
        return implode("/", $this->pathElements);
    }
}
