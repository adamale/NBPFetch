<?php
declare(strict_types=1);

namespace NBPFetch\ApiCaller;

use NBPFetch\NBPApi\NBPApi;

/**
 * Class AbstractApiCaller
 * @package NBPFetch\ApiCaller
 */
abstract class AbstractApiCaller implements ApiCallerInterface
{
    /**
     * @var NBPApi
     */
    private $NBPApi;

    /**
     * @param NBPApi $NBPApi
     */
    public function __construct(NBPApi $NBPApi)
    {
        $this->NBPApi = $NBPApi;
    }

    /**
     * @return NBPApi
     */
    protected function getNBPApi(): NBPApi
    {
        return $this->NBPApi;
    }
}