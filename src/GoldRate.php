<?php
declare(strict_types=1);

namespace NBPFetch;


/**
 * Class GoldRate
 * @package NBPFetch
 */
class GoldRate implements ItemInterface
{
    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $rate;

    public function __construct(string $date, string $rate)
    {
        $this->date = $date;
        $this->rate = $rate;
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
    public function getRate(): ?string
    {
        return $this->rate;
    }
}