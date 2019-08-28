<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Functional;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use NBPFetch;
use NBPFetch\GoldPrice\GoldPrice;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

/**
 * Class FetchingGoldPriceTest
 * @covers NBPFetch\GoldPrice\Fetcher
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
    public function canFetchTodaysPrice()
    {
        $currentDate = DateTimeImmutable::createFromFormat(
            "Y-m-d",
            date("Y-m-d"),
            new DateTimeZone("Europe/Warsaw")
        );
        if ($currentDate === false) {
            throw new UnexpectedValueException("Current date is not a DateTimeImmutable");
        }

        $NBPFetch = new NBPFetch\NBPFetch();
        $currentPrice = $NBPFetch->goldPrice()->current();
        $currentPriceDate = $currentPrice->getDate();

        if ($currentPriceDate === $currentDate->format("Y-m-d")) {
            $this->assertInstanceOf(GoldPrice::class, $NBPFetch->goldPrice()->today());
        } else {
            $this->expectExceptionMessage("Error while fetching data from NBP API");
            $NBPFetch->goldPrice()->today();
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

        $this->assertEquals(
            $testDate,
            $NBPFetch->goldPrice()->byDate($testDate)->getDate()
        );
    }

    /**
     * @test
     */
    public function canFetchByDateRange()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $givenDateRangePrice = $NBPFetch->goldPrice()->byDateRange("2019-06-01", "2019-06-30");

        $this->assertEquals(
            19,
            count($givenDateRangePrice)
        );
    }

    /**
     * @test
     */
    public function cannotFetchWithFutureDate()
    {
        $futureDate = date("Y-m-d", strtotime("+1 month"));

        $this->expectExceptionMessage("Date must not be in the future");

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->goldPrice()->byDate($futureDate);
    }

    /**
     * @test
     */
    public function cannotFetchWithTooOldDate()
    {
        $minimalAcceptedDate = DateTimeImmutable::createFromFormat(
            "Y-m-d",
            "2013-01-02",
            new DateTimeZone("Europe/Warsaw")
        );
        if ($minimalAcceptedDate === false) {
            throw new UnexpectedValueException("Minimal accepted date is not a DateTimeImmutable");
        }

        $tooOldDate = $minimalAcceptedDate->sub(new DateInterval("P1D"));

        $this->expectExceptionMessage(
            sprintf(
                "Date must not be before %s",
                $minimalAcceptedDate->format("Y-m-d")
            )
        );

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->goldPrice()->byDate($tooOldDate->format("Y-m-d"));
    }

    /**
     * @test
     */
    public function cannotFetchWithInvalidDate()
    {
        $invalidDate = "28-08-2019";
        $dateFormat = "Y-m-d";

        $this->expectExceptionMessage(sprintf("Date must be in %s format", $dateFormat));

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->goldPrice()->byDate($invalidDate);
    }

    /**
     * @test
     */
    public function cannotFetchWithInvalidCount()
    {
        $invalidCount = 0;
        $minimalCount = 1;

        $this->expectExceptionMessage(sprintf("Count must not be lower than %s", $minimalCount));

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->goldPrice()->last($invalidCount);
    }

    /**
     * @test
     */
    public function cannotFetchWithDateThatLacksGoldPrice()
    {
        $dateThatLacksGoldPrice = "2019-07-06";

        $this->expectExceptionMessage("Error while fetching data from NBP API");

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->goldPrice()->byDate($dateThatLacksGoldPrice);
    }
}
