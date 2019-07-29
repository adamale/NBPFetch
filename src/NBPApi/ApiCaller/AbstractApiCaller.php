<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\ApiCaller;

use NBPFetch\NBPApi\NBPApi;

/**
 * Class AbstractApiCaller
 * @package NBPFetch\NBPApi\ApiCaller
 */
abstract class AbstractApiCaller implements ApiCallerInterface
{
    /**
     * @var string|null
     */
    protected $error;

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
     * @param string $error
     * @return void
     */
    protected function setError(string $error): void
    {
        $this->error = $error;
    }

    /**
     * Returns an API error.
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Clears the last error and fetches data with full URL.
     * @param string $url
     * @return array
     * @throws \InvalidArgumentException
     */
    protected function fetch(string $url):array
    {
        $this->error = null;
        return $this->NBPApi->fetch($url);
    }
}