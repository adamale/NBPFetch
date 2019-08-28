<?php
declare(strict_types=1);

namespace NBPFetch\ApiCaller;

use NBPFetch\NBPApi\NBPApiInterface;

/**
 * Class AbstractApiCaller
 * @package NBPFetch\ApiCaller
 */
abstract class AbstractApiCaller
{
    /**
     * @var NBPApiInterface
     */
    private $NBPApi;

    /**
     * @param NBPApiInterface $NBPApi
     */
    public function __construct(NBPApiInterface $NBPApi)
    {
        $this->NBPApi = $NBPApi;
    }

    /**
     * @return NBPApiInterface
     */
    protected function getNBPApi(): NBPApiInterface
    {
        return $this->NBPApi;
    }
}
