<?php
declare(strict_types=1);

namespace NBPFetch;

/**
 * Class Collection
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @package NBPFetch
 */
abstract class Collection implements
    CollectionInterface,
    \Countable,
    \Iterator
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * @var int
     */
    private $current = 0;

    protected function insert(ItemInterface $item): void
    {
        $this->items[] = $item;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function current(): ?ItemInterface
    {
        return $this->items[$this->current];
    }

    public function next(): int
    {
        return $this->current++;
    }

    public function key(): int
    {
        return $this->current;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->current]);
    }

    public function rewind(): void
    {
        $this->current = 0;
    }


}