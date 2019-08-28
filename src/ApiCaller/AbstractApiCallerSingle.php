<?php
declare(strict_types=1);

namespace NBPFetch\ApiCaller;

/**
 * Class AbstractApiCallerSingle
 * @package NBPFetch\ApiCaller
 */
abstract class AbstractApiCallerSingle extends AbstractApiCaller implements ApiCallerSingleInterface
{
    /**
     * Returns full API response array.
     * @param string $path
     * @return mixed
     */
    abstract public function get(string $path);
}
