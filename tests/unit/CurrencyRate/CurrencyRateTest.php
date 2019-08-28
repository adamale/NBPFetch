<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Unit\CurrencyRate;

use NBPFetch\CurrencyRate\CurrencyRate;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class CurrencyRateTest
 * @package NBPFetch\Tests\Unit\CurrencyRate
 */
class CurrencyRateTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedWithValidArgs()
    {
        $table_number = "163/A/NBP/2019";
        $date = "2019-08-23";
        $rate = "3.9876";

        $this->assertInstanceOf(
            CurrencyRate::class,
            new CurrencyRate($table_number, $date, $rate)
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidTableNumber()
    {
        $table_number = true;
        $date = "2019-08-23";
        $rate = "3.9876";

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new CurrencyRate($table_number, $date, $rate);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidDate()
    {
        $table_number = "163/A/NBP/2019";
        $date = true;
        $rate = "3.9876";

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new CurrencyRate($table_number, $date, $rate);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidRate()
    {
        $table_number = "163/A/NBP/2019";
        $date = "2019-08-23";
        $rate = true;

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new CurrencyRate($table_number, $date, $rate);
    }

    /**
     * @test
     */
    public function tableNumberCanBeReadFrom()
    {
        $table_number = "163/A/NBP/2019";
        $date = "2019-08-23";
        $rate = "3.9876";

        $currencyRate = new CurrencyRate($table_number, $date, $rate);

        $this->assertEquals(
            $table_number,
            $currencyRate->getTableNumber()
        );
    }

    /**
     * @test
     */
    public function dateCanBeReadFrom()
    {
        $table_number = "163/A/NBP/2019";
        $date = "2019-08-23";
        $rate = "3.9876";

        $currencyRate = new CurrencyRate($table_number, $date, $rate);

        $this->assertEquals(
            $date,
            $currencyRate->getDate()
        );
    }

    /**
     * @test
     */
    public function rateCanBeReadFrom()
    {
        $table_number = "163/A/NBP/2019";
        $date = "2019-08-23";
        $rate = "3.9876";

        $currencyRate = new CurrencyRate($table_number, $date, $rate);

        $this->assertEquals(
            $rate,
            $currencyRate->getRate()
        );
    }
}
