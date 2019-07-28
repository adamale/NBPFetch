<?php
declare(strict_types=1);

namespace NBPFetch;

interface CollectionInterface
{
    public function add(ItemInterface $item): void;
}