<?php
declare(strict_types=1);

namespace NBPFetch\Module\ExchangeRateTable\Structure;

/**
 * Class ExchangeRateTable\Structure
 * @package NBPFetch\Module\ExchangeRateTable
 */
class ExchangeRateTable
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $date;

    /**
     * @var ExchangeRateCollection
     */
    private $exchangeRateCollection;

    /**
     * @param string $table
     * @param string $number
     * @param string $date
     * @param ExchangeRateCollection $exchangeRateCollection
     */
    public function __construct(
        string $table,
        string $number,
        string $date,
        ExchangeRateCollection $exchangeRateCollection
    ) {
        $this->table = $table;
        $this->number = $number;
        $this->date = $date;
        $this->exchangeRateCollection = $exchangeRateCollection;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return ExchangeRateCollection
     */
    public function getExchangeRateCollection(): ExchangeRateCollection
    {
        return $this->exchangeRateCollection;
    }
}
