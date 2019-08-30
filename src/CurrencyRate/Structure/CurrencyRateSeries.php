<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate\Structure;

/**
 * Class CurrencyRateSeries
 * @package NBPFetch\CurrencyRate\Structure
 */
class CurrencyRateSeries
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $code;

    /**
     * @var CurrencyRateCollection
     */
    private $currencyRateCollection;

    /**
     * CurrencyRateSeries constructor.
     * @param string $table
     * @param string $currency
     * @param string $code
     * @param CurrencyRateCollection $currencyRateCollection
     */
    public function __construct(
        string $table,
        string $currency,
        string $code,
        CurrencyRateCollection $currencyRateCollection
    ) {
        $this->table = $table;
        $this->currency = $currency;
        $this->code = $code;
        $this->currencyRateCollection = $currencyRateCollection;
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
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return CurrencyRateCollection
     */
    public function getCurrencyRateCollection(): CurrencyRateCollection
    {
        return $this->currencyRateCollection;
    }
}
