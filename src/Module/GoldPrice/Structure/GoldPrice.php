<?php
declare(strict_types=1);

namespace NBPFetch\Module\GoldPrice\Structure;

/**
 * Class GoldPrice
 * @package NBPFetch\Module\GoldPrice\Structure
 */
class GoldPrice
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
     * @param string $date
     * @param string $price
     */
    public function __construct(string $date, string $price)
    {
        $this->date = $date;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }
}
