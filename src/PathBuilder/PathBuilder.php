<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder;

use InvalidArgumentException;
use NBPFetch\PathBuilder\ValidatablePathSegments\AbstractValidatablePathSegment;

/**
 * Class PathBuilder
 * @package NBPFetch\PathBuilder
 */
class PathBuilder
{
    /**
     * @var PathSegment[]
     */
    private $pathSegments;

    /**
     * Adds multiple segments to the path.
     * @param PathSegment ...$pathSegments
     * @return void
     * @throws InvalidArgumentException
     */
    public function addSegments(PathSegment ...$pathSegments): void
    {
        if (!empty($pathSegments)) {
            foreach ($pathSegments as $pathSegment) {
                $this->addSegment($pathSegment);
            }
        }
    }

    /**
     * Adds a segment to the path.
     * @param PathSegment $pathSegment
     * @return void
     * @throws InvalidArgumentException
     */
    public function addSegment(PathSegment $pathSegment): void
    {
        if ($pathSegment instanceof AbstractValidatablePathSegment) {
            $pathSegment->validate();
        }

        $this->pathSegments[] = $pathSegment;
    }

    /**
     * Builds a request path.
     * @return string
     */
    public function build(): string
    {
        return implode("/", $this->pathSegments);
    }
}
