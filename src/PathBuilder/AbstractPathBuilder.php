<?php
declare(strict_types=1);

namespace NBPFetch\PathBuilder;

/**
 * Class AbstractPathBuilder
 * @package NBPFetch\PathBuilder
 */
abstract class AbstractPathBuilder
{
    /**
     * @var string[]
     */
    private $basePathElements;

    /**
     * PathBuilder constructor.
     * @param string ...$basePathElements
     */
    public function __construct(string ...$basePathElements)
    {
        $this->basePathElements = $basePathElements;
    }

    /**
     * @return string
     */
    abstract public function build(): string;

    /**
     * Returns parsed data from NBP API.
     * @param string ...$methodPathElements
     * @return string
     */
    protected function buildSubPath(string ...$methodPathElements): string
    {
        $pathElements = array_merge($this->basePathElements, $methodPathElements);

        $validPathElements = $this->filterPathElements($pathElements);

        return implode("/", $validPathElements);
    }

    /**
     * @param array $pathElements
     * @return array
     */
    private function filterPathElements(array $pathElements): array
    {
        $filteredPathElements = [];

        if (count($pathElements) > 0) {
            $filteredPathElements = array_filter(
                $pathElements,
                function ($el) {
                    return (bool) mb_strlen($el);
                }
            );
        }

        return $filteredPathElements;
    }
}
