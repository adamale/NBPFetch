<?php
declare(strict_types=1);

namespace NBPFetch;

class GoldPriceCollection extends Collection
{
    public function add(ItemInterface $goldPrice): void
    {
        if ($goldPrice instanceof GoldPrice) {
            $this->insert($goldPrice);
        }
    }
}