<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Functional;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use NBPFetch;
use NBPFetch\GoldPrice\GoldPrice;
use NBPFetch\GoldPrice\Structure;
use PHPUnit\Framework\TestCase;

/**
 * Class FetchingGoldPriceTest
 * @covers NBPFetch\GoldPrice\GoldPrice
 */
final class FetchingGoldPriceTest extends TestCase
{
    /**
     * @test
     */
    public function canFetchCurrentPrice()
    {
        $goldPrice = new GoldPrice();
        $currentGoldPrice = $goldPrice->current();

        $this->assertInstanceOf(
            Structure\GoldPrice::class,
            $currentGoldPrice
        );
    }

    /**
     * @test
     * @throws Exception
     */
    public function canFetchTodaysPrice()
    {
        $goldPrice = new GoldPrice();
        $currentGoldPrice = $goldPrice->current();
        $currentPriceDate = $currentGoldPrice->getDate();
        $currentDate = new DateTimeImmutable("now", new DateTimeZone("Europe/Warsaw"));

        if ($currentPriceDate === $currentDate->format("Y-m-d")) {
            $this->assertInstanceOf(Structure\GoldPrice::class, $goldPrice->today());
        } else {
            $this->expectExceptionMessage("Error while fetching data from NBP API");
            $goldPrice->today();
        }
    }

    /**
     * @test
     */
    public function canFetchLast10Prices()
    {
        $goldPrice = new GoldPrice();
        $last10Prices = $goldPrice->last(10);

        $this->assertEquals(
            10,
            count($last10Prices)
        );
    }

    /**
     * @test
     */
    public function canFetchPriceByWeekdayDate()
    {
        $weekdayDate = "2019-07-29";

        $goldPrice = new GoldPrice();

        $this->assertEquals(
            $weekdayDate,
            $goldPrice->byDate($weekdayDate)->getDate()
        );
    }

    /**
     * @test
     */
    public function canFetchPricesByDateRange()
    {
        $goldPrice = new GoldPrice();
        $givenDateRangePrice = $goldPrice->byDateRange("2019-06-01", "2019-06-30");

        $this->assertEquals(
            19,
            count($givenDateRangePrice)
        );
    }

    /**
     * @test
     */
    public function cannotFetchPriceWithFutureDate()
    {
        $futureDate = date("Y-m-d", strtotime("+1 month"));

        $this->expectExceptionMessage("Date must not be in the future");

        $goldPrice = new GoldPrice();
        $goldPrice->byDate($futureDate);
    }

    /**
     * @test
     * @throws Exception
     */
    public function cannotFetchPriceWithTooOldDate()
    {
        $minimalAcceptedDate = new DateTimeImmutable("2013-01-02", new DateTimeZone("Europe/Warsaw"));
        $tooOldDate = $minimalAcceptedDate->sub(new DateInterval("P1D"));

        $this->expectExceptionMessage(
            sprintf(
                "Date must not be before %s",
                $minimalAcceptedDate->format("Y-m-d")
            )
        );

        $goldPrice = new GoldPrice();
        $goldPrice->byDate($tooOldDate->format("Y-m-d"));
    }

    /**
     * @test
     */
    public function cannotFetchPriceWithInvalidDate()
    {
        $weekendDate = "28-08-2019";
        $dateFormat = "Y-m-d";

        $this->expectExceptionMessage(sprintf("Date must be in %s format", $dateFormat));

        $goldPrice = new GoldPrice();
        $goldPrice->byDate($weekendDate);
    }

    /**
     * @test
     */
    public function cannotFetchPricesWithInvalidCount()
    {
        $invalidCount = 0;
        $minimalCount = 1;

        $this->expectExceptionMessage(sprintf("Count must not be lower than %s", $minimalCount));

        $goldPrice = new GoldPrice();
        $goldPrice->last($invalidCount);
    }

    /**
     * @test
     */
    public function cannotFetchPriceWithDateThatLacksGoldPrice()
    {
        $dateThatLacksGoldPrice = "2019-07-06";

        $this->expectExceptionMessage("Error while fetching data from NBP API");

        $goldPrice = new GoldPrice();
        $goldPrice->byDate($dateThatLacksGoldPrice);
    }
}
