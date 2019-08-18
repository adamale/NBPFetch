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
        $currentDate = DateTimeImmutable::createFromFormat(
            "Y-m-d",
            date("Y-m-d"),
            new DateTimeZone("Europe/Warsaw")
        );

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $todayPrice = $NBPFetch->goldPrice()->today();
            $currentPrice = $NBPFetch->goldPrice()->current();

            if ($currentPrice->getDate() === $currentDate->format("Y-m-d")) {
                $this->assertInstanceOf(
                    GoldPrice::class,
                    $todayPrice
                );
            }
        } catch(UnexpectedValueException $e) {
            $this->assertEquals(
                "404 NotFound - Not Found - Brak danych",
                $e->getMessage()
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

    /**
     * @test
     */
    public function cannotFetchWithFutureDate()
    {
        $message = "";

        $currentDate = DateTimeImmutable::createFromFormat(
            "Y-m-d",
            date("Y-m-d"),
            new DateTimeZone("Europe/Warsaw")
        );
        $futureDate = date("Y-m-d", strtotime("+1 month"));

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $NBPFetch->goldPrice()->byDate($futureDate);
        } catch (InvalidArgumentException|UnexpectedValueException $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals(
            sprintf("Date must not be in the future (after %s)", $currentDate->format("Y-m-d")),
            $message
        );
    }

    /**
     * @test
     */
    public function cannotFetchWithTooOldDate()
    {
        $message = "";

        $minimalAcceptedDate = DateTimeImmutable::createFromFormat(
            "Y-m-d",
            "2013-01-02",
            new DateTimeZone("Europe/Warsaw")
        );
        $tooOldDate = date("Y-m-d", strtotime("-1 day", strtotime($minimalAcceptedDate->format("Y-m-d"))));

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $NBPFetch->goldPrice()->byDate($tooOldDate);
        } catch (InvalidArgumentException|UnexpectedValueException $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals(
            sprintf("Date must not be before %s", $minimalAcceptedDate->format("Y-m-d")),
            $message
        );
    }

    /**
     * @test
     */
    public function cannotFetchWithInvalidDate()
    {
        $message = "";

        $invalidDate = "asd";
        $dateFormat = "Y-m-d";

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $NBPFetch->goldPrice()->byDate($invalidDate);
        } catch (InvalidArgumentException|UnexpectedValueException $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals(
            sprintf("Date must be in %s format", $dateFormat),
            $message
        );
    }

    /**
     * @test
     */
    public function cannotFetchWithInvalidCount()
    {
        $message = "";

        $invalidCount = 0;
        $minimalCount = 1;

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $NBPFetch->goldPrice()->last($invalidCount);
        } catch (InvalidArgumentException|UnexpectedValueException $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals(
            sprintf("Count must not be lower than %s", $minimalCount),
            $message
        );
    }

    /**
     * @test
     */
    public function cannotFetchWithDateThatLacksGoldPrice()
    {
        $message = "";

        $dateThatLacksGoldPrice = "2019-07-06";

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $NBPFetch->goldPrice()->byDate($dateThatLacksGoldPrice);
        } catch (InvalidArgumentException|UnexpectedValueException $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals(
            "404 NotFound - Not Found - Brak danych",
            $message
        );
    }
}