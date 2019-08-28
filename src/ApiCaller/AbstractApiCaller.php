<?php
declare(strict_types=1);

namespace NBPFetch\ApiCaller;

use NBPFetch\NBPApi\NBPApiInterface;
use TypeError;
use UnexpectedValueException;

/**
 * Class AbstractApiCaller
 * @package NBPFetch\ApiCaller
 */
abstract class AbstractApiCaller implements ApiCallerInterface
{
    /**
     * @var NBPApiInterface
     */
    private $NBPApi;

    /**
     * @param NBPApiInterface $NBPApi
     * @return void
     */
    public function setNBPApi(NBPApiInterface $NBPApi): void
    {
        $this->NBPApi = $NBPApi;
    }

    /**
     * Gets a response from NBP API and parses it for further processing.
     * @param string $path
     * @return array
     * @throws TypeError
     * @throws UnexpectedValueException
     */
    protected function getFromNBPAPI(string $path): array
    {
        if (!is_a($this->NBPApi, NBPApiInterface::class)) {
            throw new TypeError("NBPApi is not properly defined");
        }

        return $this->NBPApi->fetch($path);
    }
}
