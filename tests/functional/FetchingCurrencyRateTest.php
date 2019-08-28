<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Functional;

use DateTimeImmutable;
use DateTimeZone;
use NBPFetch;
use NBPFetch\CurrencyRate\CurrencyRateSeries;
use PHPUnit\Framework\TestCase;

/**
 * Class FetchingCurrencyRateTest
 * @covers NBPFetch\CurrencyRate\Fetcher
 */
final class FetchingCurrencyRateTest extends TestCase
{
    /**
     * @test
     */
    public function canFetchCurrent()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $currentCurrencyRate = $NBPFetch->currencyRate()->current("EUR");

        $this->assertInstanceOf(
            CurrencyRateSeries::class,
            $currentCurrencyRate
        );
    }

    /**
     * @test
     */
    public function canFetchTodays()
    {
        $currentDate = DateTimeImmutable::createFromFormat(
            "Y-m-d",
            date("Y-m-d"),
            new DateTimeZone("Europe/Warsaw")
        );

        $NBPFetch = new NBPFetch\NBPFetch();
        $currentCurrencyRate = $NBPFetch->currencyRate()->current("EUR");

        if ($currentCurrencyRate->getCurrencyRateCollection()[0]->getDate() === $currentDate->format("Y-m-d")) {
            $this->assertInstanceOf(
                CurrencyRateSeries::class,
                $NBPFetch->currencyRate()->today("EUR")
            );
        } else {
            $this->expectExceptionMessage("Error while fetching data from NBP API");
            $NBPFetch->currencyRate()->today("EUR");
        }
    }

    /**
     * @test
     */
    public function canFetchLast10()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $currencyRateSeries = $NBPFetch->currencyRate()->last("EUR", 10);

        $this->assertEquals(
            10,
            count($currencyRateSeries->getCurrencyRateCollection())
        );
    }

    /**
     * @test
     */
    public function canFetchByWeekdayDate()
    {
        $testDate = "2019-08-23";

        $NBPFetch = new NBPFetch\NBPFetch();
        $givenDateCurrencyRateSeries = $NBPFetch->currencyRate()->byDate("EUR", $testDate);

        $this->assertEquals(
            $testDate,
            $givenDateCurrencyRateSeries->getCurrencyRateCollection()[0]->getDate()
        );
    }

    /**
     * @test
     */
    public function canFetchByDateRange()
    {
        $NBPFetch = new NBPFetch\NBPFetch();
        $givenDateCurrencyRateSeries = $NBPFetch->currencyRate()->byDateRange(
            "EUR",
            "2019-07-01",
            "2019-07-31"
        );

        $this->assertEquals(
            23,
            count($givenDateCurrencyRateSeries->getCurrencyRateCollection())
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
        $NBPFetch->currencyRate()->byDate("EUR", $futureDate);
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
        $NBPFetch->currencyRate()->byDate("EUR", $tooOldDate);
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
        $NBPFetch->currencyRate()->byDate("EUR", $invalidDate);
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
        $NBPFetch->currencyRate()->last("EUR", $invalidCount);
    }

    /**
     * @test
     */
    public function cannotFetchWithDateThatLacksExchangeRateTable()
    {
        $dateThatLacksCurrencyRate = "2019-08-11";

        $this->expectExceptionMessage("Error while fetching data from NBP API");

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->currencyRate()->byDate("EUR", $dateThatLacksCurrencyRate);
    }

    /**
     * @test
     */
    public function cannotFetchWithCurrencyThatDoesntConsistsOfOnlyLetters()
    {
        $incorrectCurrency = "E2U";

        $this->expectExceptionMessage("Currency must consists only of letters");

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->currencyRate()->current($incorrectCurrency);
    }

    /**
     * @test
     */
    public function cannotFetchWithCurrencyThatLengthIsInvalid()
    {
        $incorrectCurrency = "EU";

        $this->expectExceptionMessage("Currency must be 3 characters long");

        $NBPFetch = new NBPFetch\NBPFetch();
        $NBPFetch->currencyRate()->current($incorrectCurrency);
    }
}
