<?php
declare(strict_types=1);

use NBPFetch\GoldRate;
use PHPUnit\Framework\TestCase;


/**
 * Class GoldRateTest
 * @covers NBPFetch\GoldRate
 */
final class GoldRateTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedWithValidArgs()
    {
        $date = "2019-07-28";
        $rate = "9.8765";

        $this->assertInstanceOf(
            "NBPFetch\GoldRate",
            new GoldRate($date, $rate)
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidDate()
    {
        $error = null;

        $date = true;
        $rate = "9.8765";

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new GoldRate($date, $rate);
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

        $date = "2019-07-28";
        $rate = 9.8765;

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new GoldRate($date, $rate);
        } catch (Error $e) {
            $error = $e;
        }

        $this->assertInstanceOf(
            "Error",
            $error
        );
    }

    public function testDateCanBeReadFrom()
    {
        $date = "2019-07-28";
        $rate = "9.8765";

        $goldRate = new GoldRate($date, $rate);

        $this->assertEquals(
            $date,
            $goldRate->getDate()
        );
    }

    public function testRateCanBeReadFrom()
    {
        $date = "2019-07-28";
        $rate = "9.8765";

        $goldRate = new GoldRate($date, $rate);

        $this->assertEquals(
            $rate,
            $goldRate->getRate()
        );
    }
}