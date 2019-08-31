<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice\PathBuilder;

use NBPFetch\PathBuilder\AbstractPathBuilder;

/**
 * Class PathBuilder
 * @package NBPFetch\GoldPrices\PathBuilder
 */
class PathBuilder extends AbstractPathBuilder
{
    /**
     * @var string API_SUBSET API Subset that returns gold price data.
     */
    private const API_SUBSET = "cenyzlota/";

    /**
     * @param string ...$methodPathElements
     * @return string
     */
    public function build(string ...$methodPathElements): string
    {
        return sprintf(
            "%s%s",
            self::API_SUBSET,
            $this->buildSubPath(...$methodPathElements)
        );
    }
}
