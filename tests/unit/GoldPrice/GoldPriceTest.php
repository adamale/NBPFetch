<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Unit\GoldPrice;

use NBPFetch;
use NBPFetch\GoldPrice\GoldPrice;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class GoldPriceTest
 * @covers NBPFetch\GoldPrice
 */
final class GoldPriceTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedWithValidArgs()
    {
        $date = "2019-07-28";
        $price = "9.8765";

        $this->assertInstanceOf(
            GoldPrice::class,
            new GoldPrice($date, $price)
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidDate()
    {
        $date = true;
        $price = "9.8765";

        $this->expectException(TypeError::class);

         /** @noinspection PhpStrictTypeCheckingInspection */
         new GoldPrice($date, $price);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidPrice()
    {
        $date = "2019-07-28";
        $price = 9.8765;

        $this->expectException(TypeError::class);

         /** @noinspection PhpStrictTypeCheckingInspection */
         new GoldPrice($date, $price);
    }

    /**
     * @test
     */
    public function dateCanBeReadFrom()
    {
        $date = "2019-07-28";
        $price = "9.8765";

        $goldPrice = new GoldPrice($date, $price);

        $this->assertEquals(
            $date,
            $goldPrice->getDate()
        );
    }

    /**
     * @test
     */
    public function priceCanBeReadFrom()
    {
        $date = "2019-07-28";
        $price = "9.8765";

        $goldPrice = new GoldPrice($date, $price);

        $this->assertEquals(
            $price,
            $goldPrice->getPrice()
        );
    }
}