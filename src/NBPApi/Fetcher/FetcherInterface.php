<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\Fetcher;

/**
 * Interface FetcherInterface
 * @package NBPFetch\NBPApi\Fetcher
 */
interface FetcherInterface
{
    /**
     * @return mixed
     */
    public function getApiCaller();
}