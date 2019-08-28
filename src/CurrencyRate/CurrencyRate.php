<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

/**
 * Class CurrencyRate
 * @package NBPFetch\CurrencyRate
 */
class CurrencyRate
{
    /**
     * @var string
     */
    private $table_number;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $rate;

    /**
     * CurrencyRate constructor.
     * @param string $table_number
     * @param string $date
     * @param string $rate
     */
    public function __construct(string $table_number, string $date, string $rate)
    {
        $this->table_number = $table_number;
        $this->date = $date;
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getTableNumber(): string
    {
        return $this->table_number;
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
    public function getRate(): string
    {
        return $this->rate;
    }
}
