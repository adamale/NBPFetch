<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\Fetcher;

use NBPFetch\NBPApi\ApiCaller\ApiCallerInterface;

/**
 * Class AbstractFetcher
 * @package NBPFetch\NBPApi\Fetcher
 */
class AbstractFetcher implements FetcherInterface
{
    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;

    /**
     * AbstractFetcher constructor.
     * @param ApiCallerInterface $apiCaller
     */
    public function __construct(ApiCallerInterface $apiCaller)
    {
        $this->apiCaller = $apiCaller;
    }

    /**
     * @return ApiCallerInterface
     */
    public function getApiCaller()
    {
        return $this->apiCaller;
    }
}