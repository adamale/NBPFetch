<?php
declare(strict_types=1);

use NBPFetch\Structure\ExchangeRate\ExchangeRate;
use NBPFetch\Structure\ExchangeRate\ExchangeRateCollection;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTable;
use PHPUnit\Framework\TestCase;

/**
 * Class ExchangeRateTableTest
 * @covers \NBPFetch\Structure\ExchangeRate\ExchangeRateTable
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
        $exchangeRateCollection->add(new ExchangeRate("USD", "3.9876"));
        $exchangeRateCollection->add(new ExchangeRate("EUR", "4.1234"));
        $exchangeRateCollection->add(new ExchangeRate("GBP", "4.7"));

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
        $error = null;

        $table = 1;
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection->add(new ExchangeRate("USD", "3.9876"));
        $exchangeRateCollection->add(new ExchangeRate("EUR", "4.1234"));
        $exchangeRateCollection->add(new ExchangeRate("GBP", "4.7"));

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);
        } catch (Error $e) {
            $error = $e;
        }

        $this->assertInstanceOf(
            "Error",
            $error
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidNumber()
    {
        $error = null;

        $table = "A";
        $number = true;
        $date = "2019-08-13";
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection->add(new ExchangeRate("USD", "3.9876"));
        $exchangeRateCollection->add(new ExchangeRate("EUR", "4.1234"));
        $exchangeRateCollection->add(new ExchangeRate("GBP", "4.7"));

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);
        } catch (Error $e) {
            $error = $e;
        }

        $this->assertInstanceOf(
            "Error",
            $error
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidDate()
    {
        $error = null;

        $table = "A";
        $number = "156/A/NBP/2019";
        $date = true;
        $exchangeRateCollection = new ExchangeRateCollection();
        $exchangeRateCollection->add(new ExchangeRate("USD", "3.9876"));
        $exchangeRateCollection->add(new ExchangeRate("EUR", "4.1234"));
        $exchangeRateCollection->add(new ExchangeRate("GBP", "4.7"));

        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);
        } catch (Error $e) {
            $error = $e;
        }

        $this->assertInstanceOf(
            "Error",
            $error
        );
    }

    /**
     * @test
     */
    public function cannotBeCreatedWithInvalidDExchangeRateCollection()
    {
        $error = null;

        $table = "A";
        $number = "156/A/NBP/2019";
        $date = "2019-08-13";
        $exchangeRateCollection = null;
        try {
            /** @noinspection PhpStrictTypeCheckingInspection */
            new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);
        } catch (Error $e) {
            $error = $e;
        }

        $this->assertInstanceOf(
            "Error",
            $error
        );
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
        $exchangeRateCollection->add(new ExchangeRate("USD", "3.9876"));
        $exchangeRateCollection->add(new ExchangeRate("EUR", "4.1234"));
        $exchangeRateCollection->add(new ExchangeRate("GBP", "4.7"));

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
        $exchangeRateCollection->add(new ExchangeRate("USD", "3.9876"));
        $exchangeRateCollection->add(new ExchangeRate("EUR", "4.1234"));
        $exchangeRateCollection->add(new ExchangeRate("GBP", "4.7"));

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
        $exchangeRateCollection->add(new ExchangeRate("USD", "3.9876"));
        $exchangeRateCollection->add(new ExchangeRate("EUR", "4.1234"));
        $exchangeRateCollection->add(new ExchangeRate("GBP", "4.7"));

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
        $exchangeRateCollection->add(new ExchangeRate("USD", "3.9876"));
        $exchangeRateCollection->add(new ExchangeRate("EUR", "4.1234"));
        $exchangeRateCollection->add(new ExchangeRate("GBP", "4.7"));

        $exchangeRateTable = new ExchangeRateTable($table, $number, $date, $exchangeRateCollection);

        $this->assertEquals(
            $exchangeRateCollection,
            $exchangeRateTable->getExchangeRateCollection()
        );
    }
}