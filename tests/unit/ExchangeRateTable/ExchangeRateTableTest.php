<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Unit\ExchangeRateTable;

use NBPFetch\ExchangeRateTable\Structure\ExchangeRate;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateCollection;
use NBPFetch\ExchangeRateTable\Structure\ExchangeRateTable;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ExchangeRateTableTest
 * @covers \NBPFetch\ExchangeRateTable\Structure\ExchangeRateTable
 */
class ExchangeRateTableTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreatedWithValidArgs()
    {
        $table = "A";
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection[] = new ExchangeRate("USD", "3.9876");
        $exchangeRateCollection[] = new ExchangeRate("EUR", "4.1234");
        $exchangeRateCollection[] = new ExchangeRate("GBP", "4.7");

        $this->assertInstanceOf(
            ExchangeRateTable::class,
            new ExchangeRateTable($table, $number, $date, $exchangeRateCollection)
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidTable()
    {
        $table = 1;
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection[] = new ExchangeRate("USD", "3.9876");
        $exchangeRateCollection[] = new ExchangeRate("EUR", "4.1234");
        $exchangeRateCollection[] = new ExchangeRate("GBP", "4.7");

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidNumber()
    {
        $table = "A";
        $number = true;
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection[] = new ExchangeRate("USD", "3.9876");
        $exchangeRateCollection[] = new ExchangeRate("EUR", "4.1234");
        $exchangeRateCollection[] = new ExchangeRate("GBP", "4.7");

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidDate()
    {
        $table = "A";
        $number = "156/A/NBP/2019";
        $date = true;
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection[] = new ExchangeRate("USD", "3.9876");
        $exchangeRateCollection[] = new ExchangeRate("EUR", "4.1234");
        $exchangeRateCollection[] = new ExchangeRate("GBP", "4.7");

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidDExchangeRateCollection()
    {
        $table = "A";
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = null;

        $this->expectException(TypeError::class);

        /** @noinspection PhpStrictTypeCheckingInspection */
        new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);
    }

    /**
     * @test
     */
    public function tableCanBeReadFrom()
    {
        $table = "A";
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection[] = new ExchangeRate("USD", "3.9876");
        $exchangeRateCollection[] = new ExchangeRate("EUR", "4.1234");
        $exchangeRateCollection[] = new ExchangeRate("GBP", "4.7");

        $exchangeRateTable = new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);

        $this->assertEquals(
            $table,
            $exchangeRateTable->getTable()
        );
    }

    /**
     * @test
     */
    public function numberCanBeReadFrom()
    {
        $table = "A";
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection[] = new ExchangeRate("USD", "3.9876");
        $exchangeRateCollection[] = new ExchangeRate("EUR", "4.1234");
        $exchangeRateCollection[] = new ExchangeRate("GBP", "4.7");

        $exchangeRateTable = new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);

        $this->assertEquals(
            $number,
            $exchangeRateTable->getNumber()
        );
    }

    /**
     * @test
     */
    public function dateCanBeReadFrom()
    {
        $table = "A";
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection[] = new ExchangeRate("USD", "3.9876");
        $exchangeRateCollection[] = new ExchangeRate("EUR", "4.1234");
        $exchangeRateCollection[] = new ExchangeRate("GBP", "4.7");

        $exchangeRateTable = new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);

        $this->assertEquals(
            $date,
            $exchangeRateTable->getDate()
        );
    }

    /**
     * @test
     */
    public function exchangeRateCollectionCanBeReadFrom()
    {
        $table = "A";
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection[] = new ExchangeRate("USD", "3.9876");
        $exchangeRateCollection[] = new ExchangeRate("EUR", "4.1234");
        $exchangeRateCollection[] = new ExchangeRate("GBP", "4.7");

        $exchangeRateTable = new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);

        $this->assertEquals(
            $exchangeRateCollection,
            $exchangeRateTable->getExchangeRateCollection()
        );
    }
}
