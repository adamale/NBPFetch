<?php
declare(strict_types=1);

namespace NBPFetch\Fetcher;

use UnexpectedValueException;

/**
 * Interface FetcherInterface
 * @package NBPFetch\Fetcher
 */
interface FetcherInterface
{
    /**
     * @param string $url
     * @return array
     * @throws UnexpectedValueException
     */
    public function fetch(string $url): array;
}
