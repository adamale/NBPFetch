<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Functional;

use DateTimeImmutable;
use DateTimeZone;
use NBPFetch;
use NBPFetch\ExchangeRateTable\ExchangeRateTable;
use PHPUnit\Framework\TestCase;

/**
 * Class FetchingExchangeRateTableTest
 * @covers NBPFetch\ExchangeRateTable\Fetcher
 */
final class FetchingExchangeRateTableTest extends TestCase
{
    /**
     * @test
     */
    public function canFetchCurrentExchangeRateTable()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $currentExchangeRateTable = $NBPFetch->exchangeRateTable()->current("a");

        $this->assertInstanceOf(
            ExchangeRateTable::class,
            $currentExchangeRateTable
        );
    }

    /**
     * @test
     */
    public function canFetchTodayExchangeRateTable()
    {
        $currentDate = DateTimeImmutable::createFromFormat(
            "Y-m-d",
            date("Y-m-d"),
            new DateTimeZone("Europe/Warsaw")
        );

        $NBPFetch = new NBPFetch\NBPFetch();
        $currentExchangeRateTable = $NBPFetch->exchangeRateTable()->current("A");

        if ($currentExchangeRateTable->getDate() === $currentDate->format("Y-m-d")) {
            $this->assertInstanceOf(
                ExchangeRateTable::class,
                $NBPFetch->exchangeRateTable()->today("A")
            );
        } else {
            $this->expectExceptionMessage("Error while fetching data from NBP API");
            $NBPFetch->exchangeRateTable()->today("A");
        }
    }

    /**
     * @test
     */
    public function canFetchLast10ExchangeRateTables()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $last10ExchangeRateTables = $NBPFetch->exchangeRateTable()->last("A", 10);

        $this->assertEquals(
            10,
            count($last10ExchangeRateTables)
        );
    }

    /**
     * @test
     */
    public function canFetchByWeekdayDate()
    {
        $testDate = "2019-08-13";

        $NBPFetch = new NBPFetch\NBPFetch();
        $givenDatePrice = $NBPFetch->exchangeRateTable()->byDate("A", $testDate);

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
        $givenDateRangeExchangeRateTables = $NBPFetch->exchangeRateTable()->byDateRange(
            "A",
            "2019-06-01",
            "2019-06-30"
        );

        $this->assertEquals(
            19,
            count($givenDateRangeExchangeRateTables)
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
        $NBPFetch->exchangeRateTable()->byDate("A", $futureDate);
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
        $tooOldDate = date(
            "Y-m-d",
            strtotime(
                "-1 day",
                strtotime($minimalAcceptedDate->format("Y-m-d"))
            )
        );

        $this->expectExceptionMessage(
            sprintf(
                "Date must not be before %s",
                $minimalAcceptedDate->format("Y-m-d")
            )
        );

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->exchangeRateTable()->byDate("A", $tooOldDate);
    }

    /**
     * @test
     */
    public function cannotFetchWithInvalidDate()
    {
        $invalidDate = "asd";
        $dateFormat = "Y-m-d";

        $this->expectExceptionMessage(sprintf("Date must be in %s format", $dateFormat));

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->exchangeRateTable()->byDate("A", $invalidDate);
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
        $NBPFetch->exchangeRateTable()->last("A", $invalidCount);
    }

    /**
     * @test
     */
    public function cannotFetchWithDateThatLacksExchangeRateTable()
    {
        $dateThatLacksGoldPrice = "2019-08-11";

        $this->expectExceptionMessage("Error while fetching data from NBP API");

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->exchangeRateTable()->byDate("A", $dateThatLacksGoldPrice);
    }

    /**
     * @test
     */
    public function cannotFetchWithIncorrectTable()
    {
        $incorrectTable = "D";

        $this->expectExceptionMessage("Table must be one of the following: A, B");

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->exchangeRateTable()->current($incorrectTable);
    }
}