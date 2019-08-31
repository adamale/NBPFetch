<?php
declare(strict_types=1);

namespace NBPFetch\ExchangeRateTable\PathBuilder;

use NBPFetch\PathBuilder\AbstractPathBuilder;

/**
 * Class PathBuilder
 * @package NBPFetch\ExchangeRateTable\PathBuilder
 */
class PathBuilder extends AbstractPathBuilder
{
    /**
     * @var string API_SUBSET API Subset that returns exchange rate table data.
     */
    private const API_SUBSET = "exchangerates/tables/";

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
