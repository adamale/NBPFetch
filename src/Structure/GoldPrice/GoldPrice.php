<?php
declare(strict_types=1);

namespace NBPFetch\Structure\GoldPrice;

use NBPFetch\Structure\Item\ItemInterface;

/**
 * Class GoldPrice
 * @package NBPFetch\Structure\GoldPrice
 */
class GoldPrice implements ItemInterface
{
    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $price;

    /**
     * GoldPrice constructor.
     * @param string $date
     * @param string $price
     */
    public function __construct(string $date, string $price)
    {
        $this->date = $date;
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        return $this->date;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }
}