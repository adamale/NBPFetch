<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\ApiCaller;

/**
 * Interface ApiCallerInterface
 * @package NBPFetch\NBPApi\ApiCaller
 */
interface ApiCallerInterface
{
    /**
     * Returns single item from API response array.
     * @param string $path
     * @return mixed
     */
    public function getSingle(string $path);

    /**
     * Returns full API response array as collection.
     * @param string $path
     * @return mixed
     */
    public function getCollection(string $path);
}