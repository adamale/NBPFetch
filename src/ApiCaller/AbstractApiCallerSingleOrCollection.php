<?php
declare(strict_types=1);

namespace NBPFetch\ApiCaller;

/**
 * Class AbstractApiCallerSingleOrCollection
 * @package NBPFetch\ApiCaller
 */
abstract class AbstractApiCallerSingleOrCollection extends AbstractApiCaller implements
    ApiCallerSingleOrCollectionInterface
{
    /**
     * Returns single item from API response array.
     * @param string $path
     * @return mixed
     */
    abstract public function getSingle(string $path);

    /**
     * Returns full API response array as collection.
     * @param string $path
     * @return mixed
     */
    abstract public function getCollection(string $path);
}
