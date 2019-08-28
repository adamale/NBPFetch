<?php
declare(strict_types=1);

namespace NBPFetch\ApiCaller;

/**
 * Interface ApiCallerSingleOrCollectionInterface
 * @package NBPFetch\ApiCaller
 */
interface ApiCallerSingleOrCollectionInterface extends ApiCallerInterface
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
