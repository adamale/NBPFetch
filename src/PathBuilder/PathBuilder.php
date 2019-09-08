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
     * PathBuilder constructor.
     */
    public function __construct()
    {
        $this->pathSegments = [];
    }

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
     * @param int|null $position
     * @return void
     */
    public function addSegment(PathSegment $pathSegment, ?int $position = null): void
    {
        if ($pathSegment instanceof AbstractValidatablePathSegment) {
            $pathSegment->validate();
        }

        if (!is_int($position)) {
            $position = $this->computePathSegmentPosition();
        }

        $this->pathSegments[$position] = $pathSegment;
    }

    /**
     * Builds a request path.
     * @return string
     */
    public function build(): string
    {
        ksort($this->pathSegments);
        return implode("/", $this->pathSegments);
    }

    /**
     * @return int
     */
    private function computePathSegmentPosition(): int
    {
        $occupiedPositions = array_keys($this->pathSegments);

        if (empty($occupiedPositions)) {
            $position = 0;
        } else {
            $lastPosition = (int) max($occupiedPositions);
            $freePositions = array_diff(range(0, $lastPosition), $occupiedPositions);

            $position = array_shift($freePositions);

            if ($position === null) {
                $position = $lastPosition + 1;
            }
        }

        return $position;
    }
}
