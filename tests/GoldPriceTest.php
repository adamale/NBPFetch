<?php
declare(strict_types=1);

use NBPFetch\Structure\GoldPrice\GoldPrice;
use PHPUnit\Framework\TestCase;

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
        $error = null;

        $date = true;
        $price = "9.8765";

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new GoldPrice($date, $price);
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
    public function cannotBeCreatedWithInvalidPrice()
    {
        $error = null;

        $date = "2019-07-28";
        $price = 9.8765;

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new GoldPrice($date, $price);
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