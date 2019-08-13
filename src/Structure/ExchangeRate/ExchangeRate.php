<?php
declare(strict_types=1);

namespace NBPFetch\Structure\ExchangeRate;

/**
 * Class ExchangeRate
 * @package NBPFetch\Structure\ExchangeRate
 */
class ExchangeRate
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $rate;

    /**
     * @param string $code
     * @param string $rate
     */
    public function __construct(string $code, string $rate)
    {
        $this->code = $code;
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->rate;
    }
}