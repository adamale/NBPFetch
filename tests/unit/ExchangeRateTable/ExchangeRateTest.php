<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Unit\ExchangeRateTable;

use NBPFetch\ExchangeRateTable\ExchangeRate;
use PHPUnit\Framework\TestCase;
use TypeError;

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
        $code = true;
        $rate = "3.9876";

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new ExchangeRate($code, $rate);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidRate()
    {
        $code = "USD";
        $rate = 3.9876;

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new ExchangeRate($code, $rate);
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
