<?php
declare(strict_types=1);

namespace NBPFetch\Structure\Collection;

use NBPFetch\Structure\Item\ItemInterface;

/**
 * Interface CollectionInterface
 * @package NBPFetch\Structure\Collection
 */
interface CollectionInterface
{
    /**
     * Adds an item to the collection.
     * @param ItemInterface $item
     * @return void
     */
    public function add(ItemInterface $item): void;
}