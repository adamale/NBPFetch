<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate\PathBuilder;

use NBPFetch\PathBuilder\AbstractPathBuilder;

/**
 * Class PathBuilder
 * @package NBPFetch\CurrencyRate\PathBuilder
 */
class PathBuilder extends AbstractPathBuilder
{
    /**
     * @var string API_SUBSET API Subset that returns currency rate data.
     */
    private const API_SUBSET = "exchangerates/rates/";

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
