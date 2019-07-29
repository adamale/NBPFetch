<?php
declare(strict_types=1);

namespace NBPFetch\Structure\Collection;

use Countable;
use Iterator;
use NBPFetch\Structure\Item\ItemInterface;

/**
 * Class Collection
 * @package NBPFetch
 */
abstract class Collection implements
    CollectionInterface,
    Countable,
    Iterator
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @var int
     */
    private $current = 0;

    /**
     * Inserts an item into the array.
     * @param ItemInterface $item
     */
    protected function insert(ItemInterface $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return ItemInterface|null
     */
    public function current(): ?ItemInterface
    {
        return $this->items[$this->current];
    }

    /**
     * @return int
     */
    public function next(): int
    {
        return $this->current++;
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->current;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->items[$this->current]);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->current = 0;
    }


}