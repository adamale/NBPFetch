<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\ApiCaller;

use InvalidArgumentException;
use NBPFetch\NBPApi\NBPApi;

/**
 * Class AbstractApiCaller
 * @package NBPFetch\NBPApi\ApiCaller
 */
abstract class AbstractApiCaller implements ApiCallerInterface
{
    /**
     * @var NBPApi
     */
    protected $NBPApi;

    /**
     * AbstractApiCaller constructor.
     * @param NBPApi $NBPApi
     */
    public function __construct(NBPApi $NBPApi)
    {
        $this->NBPApi = $NBPApi;
    }

    /**
     * Clears the last error and fetches data with full URL.
     * @param string $url
     * @return array
     * @throws InvalidArgumentException
     */
    protected function fetch(string $url):array
    {
        return $this->NBPApi->fetch($url);
    }

    /**
     * @return string
     */
    abstract public function getDateFormat(): string;
}