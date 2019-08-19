<?php
declare(strict_types=1);

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

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $todayExchangeRateTable = $NBPFetch->exchangeRateTable()->today("A");
            $currentExchangeRateTable = $NBPFetch->exchangeRateTable()->current("A");

            if ($currentExchangeRateTable->getDate() === $currentDate->format("Y-m-d")) {
                $this->assertInstanceOf(
                    ExchangeRateTable::class,
                    $todayExchangeRateTable
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
        $message = "";

        $currentDate = DateTimeImmutable::createFromFormat(
            "Y-m-d",
            date("Y-m-d"),
            new DateTimeZone("Europe/Warsaw")
        );
        $futureDate = date("Y-m-d", strtotime("+1 month"));

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $NBPFetch->exchangeRateTable()->byDate("A", $futureDate);
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
            $NBPFetch->exchangeRateTable()->byDate("A", $tooOldDate);
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
            $NBPFetch->exchangeRateTable()->byDate("A", $invalidDate);
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
            $NBPFetch->exchangeRateTable()->last("A", $invalidCount);
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
    public function cannotFetchWithDateThatLacksExchangeRateTable()
    {
        $message = "";

        $dateThatLacksGoldPrice = "2019-08-11";

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $NBPFetch->exchangeRateTable()->byDate("A", $dateThatLacksGoldPrice);
        } catch (InvalidArgumentException|UnexpectedValueException $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals(
            "404 NotFound - Not Found - Brak danych",
            $message
        );
    }

    /**
     * @test
     */
    public function cannotFetchWithIncorrectTable()
    {
        $message = "";

        $incorrectTable = "D";

        try {
            $NBPFetch = new NBPFetch\NBPFetch();
            $NBPFetch->exchangeRateTable()->current($incorrectTable);
        } catch (InvalidArgumentException|UnexpectedValueException $e) {
            $message = $e->getMessage();
        }

        $this->assertEquals(
            "Table must be one of the following: A, B",
            $message
        );
    }
}