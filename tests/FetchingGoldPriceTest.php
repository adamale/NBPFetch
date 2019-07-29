<?php
declare(strict_types=1);

use NBPFetch\Structure\GoldPrice\GoldPrice;
use PHPUnit\Framework\TestCase;

/**
 * Class FetchingGoldPriceTest
 * @covers NBPFetch\NBPApi\GoldPrice\Fetcher
 */
final class FetchingGoldPriceTest extends TestCase
{
    /**
     * @test
     */
    public function canFetchCurrentPrice()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $currentPrice = $NBPFetch->goldPrice()->current();

        $this->assertInstanceOf(
            GoldPrice::class,
            $currentPrice
        );
    }

    /**
     * @test
     */
    public function canFetchTodayPrice()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $todayPrice = $NBPFetch->goldPrice()->today();

        if ($NBPFetch->goldPrice()->current()->getDate() === date("Y-m-d")) {
            $this->assertInstanceOf(
                GoldPrice::class,
                $todayPrice
            );
        } else {
            $this->assertEquals(
                null,
                $todayPrice
            );
        }
    }

    /**
     * @test
     */
    public function canFetchLast10Prices()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $last10Prices = $NBPFetch->goldPrice()->last(10);

        $this->assertEquals(
            10,
            count($last10Prices)
        );
    }

    /**
     * @test
     */
    public function canFetchByWeekdayDate()
    {
        $testDate = "2019-07-29";

        $NBPFetch = new NBPFetch\NBPFetch();
        $givenDatePrice = $NBPFetch->goldPrice()->byDate($testDate);

        $this->assertEquals(
            $testDate,
            $givenDatePrice->getDate()
        );
    }

    /**
     * @test
     */
    public function canFetchByDateRange()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $givenDateRangePrice = $NBPFetch->goldPrice()->byDateRange(
            "2019-06-01",
            "2019-06-30"
        );

        $this->assertEquals(
            19,
            count($givenDateRangePrice)
        );
    }
}