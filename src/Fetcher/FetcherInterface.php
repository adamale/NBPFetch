<?php
declare(strict_types=1);

namespace NBPFetch\Fetcher;

/**
 * Interface FetcherInterface
 * @package NBPFetch\Fetcher
 */
interface FetcherInterface
{
    /**
     * @return mixed
     */
    public function getApiCaller();
}