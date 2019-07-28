<?php
declare(strict_types=1);

namespace NBPFetch;

class GoldRateCollection extends Collection
{
    public function add(ItemInterface $goldRate): void
    {
        if ($goldRate instanceof GoldRate) {
            $this->insert($goldRate);
        }
    }
}