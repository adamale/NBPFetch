<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Unit\CurrencyRate;

use NBPFetch\CurrencyRate\CurrencyRate;
use NBPFetch\CurrencyRate\CurrencyRateCollection;
use NBPFetch\CurrencyRate\CurrencyRateSeries;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class CurrencyRateSeriesTest
 * @package NBPFetch\Tests\Unit\CurrencyRate
 */
class CurrencyRateSeriesTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedWithValidArgs()
    {
        $table = "A";
        $currency = "euro";
        $code = "EUR";
        $currencyRateCollection = new CurrencyRateCollection();
        $currencyRateCollection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $currencyRateCollection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $currencyRateCollection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $this->assertInstanceOf(
            CurrencyRateSeries::class,
            new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection)
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidTable()
    {
        $table = true;
        $currency = "euro";
        $code = "EUR";
        $currencyRateCollection = new CurrencyRateCollection();
        $currencyRateCollection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $currencyRateCollection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $currencyRateCollection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidCurrency()
    {
        $table = "A";
        $currency = true;
        $code = "EUR";
        $currencyRateCollection = new CurrencyRateCollection();
        $currencyRateCollection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $currencyRateCollection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $currencyRateCollection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidCode()
    {
        $table = "A";
        $currency = "euro";
        $code = true;
        $currencyRateCollection = new CurrencyRateCollection();
        $currencyRateCollection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $currencyRateCollection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $currencyRateCollection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidCurrencyRateCollection()
    {
        $table = "A";
        $currency = "euro";
        $code = "EUR";
        $currencyRateCollection = null;

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection);
    }

    /**
     * @test
     */
    public function tableCanBeReadFrom()
    {
        $table = "A";
        $currency = "euro";
        $code = "EUR";
        $currencyRateCollection = new CurrencyRateCollection();
        $currencyRateCollection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $currencyRateCollection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $currencyRateCollection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $currencyRateSeries = new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection);

        $this->assertEquals(
            $table,
            $currencyRateSeries->getTable()
        );
    }

    /**
     * @test
     */
    public function currencyCanBeReadFrom()
    {
        $table = "A";
        $currency = "euro";
        $code = "EUR";
        $currencyRateCollection = new CurrencyRateCollection();
        $currencyRateCollection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $currencyRateCollection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $currencyRateCollection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $currencyRateSeries = new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection);

        $this->assertEquals(
            $currency,
            $currencyRateSeries->getCurrency()
        );
    }

    /**
     * @test
     */
    public function codeCanBeReadFrom()
    {
        $table = "A";
        $currency = "euro";
        $code = "EUR";
        $currencyRateCollection = new CurrencyRateCollection();
        $currencyRateCollection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $currencyRateCollection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $currencyRateCollection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $currencyRateSeries = new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection);

        $this->assertEquals(
            $code,
            $currencyRateSeries->getCode()
        );
    }

    /**
     * @test
     */
    public function rateCollectionCanBeReadFrom()
    {
        $table = "A";
        $currency = "euro";
        $code = "EUR";
        $currencyRateCollection = new CurrencyRateCollection();
        $currencyRateCollection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $currencyRateCollection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $currencyRateCollection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $currencyRateSeries = new CurrencyRateSeries($table, $currency, $code, $currencyRateCollection);

        $this->assertEquals(
            $currencyRateCollection,
            $currencyRateSeries->getCurrencyRateCollection()
        );
    }
}
