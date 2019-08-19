<?php
declare(strict_types=1);

use NBPFetch\ExchangeRateTable\ExchangeRate;
use PHPUnit\Framework\TestCase;

/**
 * Class ExchangeRateTest
 * @covers \NBPFetch\ExchangeRateTable\ExchangeRate
 */
class ExchangeRateTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedWithValidArgs()
    {
        $code = "USD";
        $rate = "3.9876";

        $this->assertInstanceOf(
            ExchangeRate::class,
            new ExchangeRate($code, $rate)
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidCode()
    {
        $error = null;

        $code = true;
        $rate = "3.9876";

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new ExchangeRate($code, $rate);
        } catch (Error $e) {
            $error = $e;
        }

        $this->assertInstanceOf(
            "Error",
            $error
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidRate()
    {
        $error = null;

        $code = "USD";
        $rate = 3.9876;

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new ExchangeRate($code, $rate);
        } catch (Error $e) {
            $error = $e;
        }

        $this->assertInstanceOf(
            "Error",
            $error
        );
    }

    /**
     * @test
     */
    public function codeCanBeReadFrom()
    {
        $code = "USD";
        $rate = "3.9876";

        $exchangeRate = new ExchangeRate($code, $rate);

        $this->assertEquals(
            $code,
            $exchangeRate->getCode()
        );
    }

    /**
     * @test
     */
    public function priceCanBeReadFrom()
    {
        $date = "USD";
        $rate = "3.9876";

        $exchangeRate = new ExchangeRate($date, $rate);

        $this->assertEquals(
            $rate,
            $exchangeRate->getRate()
        );
    }

}