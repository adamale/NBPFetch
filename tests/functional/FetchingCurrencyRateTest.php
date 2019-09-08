<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Functional;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use NBPFetch;
use NBPFetch\Module\CurrencyRate\CurrencyRate;
use NBPFetch\Module\CurrencyRate\Structure\CurrencyRateSeries;
use PHPUnit\Framework\TestCase;

/**
 * Class FetchingCurrencyRateTest
 * @covers NBPFetch\Module\CurrencyRate\CurrencyRate
 */
final class FetchingCurrencyRateTest extends TestCase
{
    /**
     * @test
     */
    public function canFetchCurrentRate()
    {
        $currencyRate = new CurrencyRate("EUR");
        $currentCurrencyRate = $currencyRate->current();

        $this->assertInstanceOf(
            CurrencyRateSeries::class,
            $currentCurrencyRate
        );
    }

    /**
     * @test
     * @throws Exception
     */
    public function canFetchTodaysRate()
    {
        $currencyRate = new CurrencyRate("EUR");
        $currentCurrencyRate = $currencyRate->current();
        $currentCurrencyRateDate = $currentCurrencyRate->getCurrencyRateCollection()[0]->getDate();
        $currentDate = new DateTimeImmutable("now", new DateTimeZone("Europe/Warsaw"));

        if ($currentCurrencyRateDate === $currentDate->format("Y-m-d")) {
            $this->assertInstanceOf(
                CurrencyRateSeries::class,
                $currencyRate->today()
            );
        } else {
            $this->expectExceptionMessage("Error while fetching data from NBP API");
            $currencyRate->today();
        }
    }

    /**
     * @test
     */
    public function canFetchLast10Rates()
    {
        $currencyRate = new CurrencyRate("EUR");
        $last10CurrencyRates = $currencyRate->last(10);

        $this->assertEquals(
            10,
            count($last10CurrencyRates->getCurrencyRateCollection())
        );
    }

    /**
     * @test
     */
    public function canFetchRateByWeekdayDate()
    {
        $weekdayDate = "2019-08-23";

        $currencyRate = new CurrencyRate("EUR");
        $givenDateCurrencyRate = $currencyRate->byDate($weekdayDate);

        $this->assertEquals(
            $weekdayDate,
            $givenDateCurrencyRate->getCurrencyRateCollection()[0]->getDate()
        );
    }

    /**
     * @test
     */
    public function canFetchRatesByDateRange()
    {
        $currencyRate = new CurrencyRate("EUR");
        $givenDatesCurrencyRates = $currencyRate->byDateRange("2019-07-01", "2019-07-31");

        $this->assertEquals(
            23,
            count($givenDatesCurrencyRates->getCurrencyRateCollection())
        );
    }

    /**
     * @test
     */
    public function cannotFetchRateWithFutureDate()
    {
        $futureDate = date("Y-m-d", strtotime("+1 month"));

        $this->expectExceptionMessage("Date must not be in the future");

        $currencyRate = new CurrencyRate("EUR");
        $currencyRate->byDate($futureDate);
    }

    /**
     * @test
     * @throws Exception
     */
    public function cannotFetchRateWithTooOldDate()
    {
        $minimalAcceptedDate = new DateTimeImmutable("2013-01-02", new DateTimeZone("Europe/Warsaw"));
        $tooOldDate = $minimalAcceptedDate->sub(new DateInterval("P1D"));

        $this->expectExceptionMessage(
            sprintf(
                "Date must not be before %s",
                $minimalAcceptedDate->format("Y-m-d")
            )
        );

        $currencyRate = new CurrencyRate("EUR");
        $currencyRate->byDate($tooOldDate->format("Y-m-d"));
    }

    /**
     * @test
     */
    public function cannotFetchRateByWeekendDate()
    {
        $weekendDate = "28-08-2019";
        $dateFormat = "Y-m-d";

        $this->expectExceptionMessage(sprintf("Date must be in %s format", $dateFormat));

        $currencyRate = new CurrencyRate("EUR");
        $currencyRate->byDate($weekendDate);
    }

    /**
     * @test
     */
    public function cannotFetchRatesWithInvalidCount()
    {
        $invalidCount = 0;
        $minimalCount = 1;

        $this->expectExceptionMessage(sprintf("Count must not be lower than %s", $minimalCount));

        $currencyRate = new CurrencyRate("EUR");
        $currencyRate->last($invalidCount);
    }

    /**
     * @test
     */
    public function cannotFetchRateWithDateThatLacksCurrencyRate()
    {
        $dateThatLacksCurrencyRate = "2019-08-11";

        $this->expectExceptionMessage("Error while fetching data from NBP API");

        $currencyRate = new CurrencyRate("EUR");
        $currencyRate->byDate($dateThatLacksCurrencyRate);
    }

    /**
     * @test
     */
    public function cannotFetchRateWithCurrencyThatDoesntConsistsOfOnlyLetters()
    {
        $incorrectCurrency = "E2U";

        $this->expectExceptionMessage("Currency must consists only of letters");

        $currencyRate = new CurrencyRate($incorrectCurrency);
        $currencyRate->current();
    }

    /**
     * @test
     */
    public function cannotFetchRateWithCurrencyThatLengthIsInvalid()
    {
        $incorrectCurrency = "EU";

        $this->expectExceptionMessage("Currency must be 3 characters long");

        $currencyRate = new CurrencyRate($incorrectCurrency);
        $currencyRate->current();
    }
}
