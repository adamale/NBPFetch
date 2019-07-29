<?php
declare(strict_types=1);

namespace NBPFetch\Structure\Collection;

/**
 * Interface CollectionInterface
 * @package NBPFetch\Structure\Collection
 */
interface CollectionInterface
{
    /**
     * Adds an item to the collection.
     * @param $item
     * @return void
     */
    public function add($item): void;
}