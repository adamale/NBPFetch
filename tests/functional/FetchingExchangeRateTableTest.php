<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Functional;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use NBPFetch;
use NBPFetch\Module\ExchangeRateTable\ExchangeRateTable;
use NBPFetch\Module\ExchangeRateTable\Structure;
use PHPUnit\Framework\TestCase;

/**
 * Class FetchingExchangeRateTableTest
 * @covers NBPFetch\Module\ExchangeRateTable\ExchangeRateTable
 */
final class FetchingExchangeRateTableTest extends TestCase
{
    /**
     * @test
     */
    public function canFetchCurrentTable()
    {
        $exchangeRateTable = new ExchangeRateTable("A");
        $currentExchangeRateTable = $exchangeRateTable->current();

        $this->assertInstanceOf(
            Structure\ExchangeRateTable::class,
            $currentExchangeRateTable
        );
    }

    /**
     * @test
     * @throws Exception
     */
    public function canFetchTodaysTable()
    {
        $exchangeRateTable = new ExchangeRateTable("A");
        $currentExchangeRateTable = $exchangeRateTable->current();
        $currentExchangeRateTableDate = $currentExchangeRateTable->getDate();
        $currentDate = new DateTimeImmutable("now", new DateTimeZone("Europe/Warsaw"));

        if ($currentExchangeRateTableDate === $currentDate->format("Y-m-d")) {
            $this->assertInstanceOf(
                ExchangeRateTable::class,
                $currentExchangeRateTable = $exchangeRateTable->today()
            );
        } else {
            $this->expectExceptionMessage("Error while fetching data from NBP API");
            $exchangeRateTable->today();
        }
    }

    /**
     * @test
     */
    public function canFetchLast10Tables()
    {
        $exchangeRateTable = new ExchangeRateTable("A");
        $last10ExchangeRateTables = $exchangeRateTable->last(10);

        $this->assertEquals(
            10,
            count($last10ExchangeRateTables)
        );
    }

    /**
     * @test
     */
    public function canFetchTableByWeekdayDate()
    {
        $weekdayDate = "2019-08-13";

        $exchangeRateTable = new ExchangeRateTable("A");
        $givenDateExchangeRateTable = $exchangeRateTable->byDate($weekdayDate);

        $this->assertEquals(
            $weekdayDate,
            $givenDateExchangeRateTable->getDate()
        );
    }

    /**
     * @test
     */
    public function canFetchTablesByDateRange()
    {
        $exchangeRateTable = new ExchangeRateTable("A");
        $givenDateRangeExchangeRateTables = $exchangeRateTable->byDateRange("2019-06-01", "2019-06-30");

        $this->assertEquals(
            19,
            count($givenDateRangeExchangeRateTables)
        );
    }

    /**
     * @test
     */
    public function cannotFetchTableWithFutureDate()
    {
        $futureDate = date("Y-m-d", strtotime("+1 month"));

        $this->expectExceptionMessage("Date must not be in the future");

        $exchangeRateTable = new ExchangeRateTable("A");
        $exchangeRateTable->byDate($futureDate);
    }

    /**
     * @test
     * @throws Exception
     */
    public function cannotFetchTableWithTooOldDate()
    {
        $minimalAcceptedDate = new DateTimeImmutable("2013-01-02", new DateTimeZone("Europe/Warsaw"));
        $tooOldDate = $minimalAcceptedDate->sub(new DateInterval("P1D"));

        $this->expectExceptionMessage(
            sprintf(
                "Date must not be before %s",
                $minimalAcceptedDate->format("Y-m-d")
            )
        );

        $exchangeRateTable = new ExchangeRateTable("A");
        $exchangeRateTable->byDate($tooOldDate->format("Y-m-d"));
    }

    /**
     * @test
     */
    public function cannotFetchTableWithWeekendDate()
    {
        $weekendDate = "28-08-2019";
        $dateFormat = "Y-m-d";

        $this->expectExceptionMessage(sprintf("Date must be in %s format", $dateFormat));

        $exchangeRateTable = new ExchangeRateTable("A");
        $exchangeRateTable->byDate($weekendDate);
    }

    /**
     * @test
     */
    public function cannotFetchTablesWithInvalidCount()
    {
        $invalidCount = 0;
        $minimalCount = 1;

        $this->expectExceptionMessage(sprintf("Count must not be lower than %s", $minimalCount));

        $exchangeRateTable = new ExchangeRateTable("A");
        $exchangeRateTable->last($invalidCount);
    }

    /**
     * @test
     */
    public function cannotFetchTableWithDateThatLacksExchangeRateTable()
    {
        $dateThatLacksExchangeRateTable = "2019-08-11";

        $this->expectExceptionMessage("Error while fetching data from NBP API");

        $exchangeRateTable = new ExchangeRateTable("A");
        $exchangeRateTable->byDate($dateThatLacksExchangeRateTable);
    }

    /**
     * @test
     */
    public function cannotFetchTableWithIncorrectTable()
    {
        $incorrectTable = "D";

        $this->expectExceptionMessage("Table must be one of the following: A, B");

        $exchangeRateTable = new ExchangeRateTable($incorrectTable);
        $exchangeRateTable->current();
    }
}
