<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Unit\ExchangeRateTable;

use NBPFetch\ExchangeRateTable\ExchangeRate;
use NBPFetch\ExchangeRateTable\ExchangeRateCollection;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class ExchangeRateCollectionTest
 * @covers \NBPFetch\ExchangeRateTable\ExchangeRateCollection
 */
final class ExchangeRateCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreated()
    {
        $this->assertInstanceOf(
            ExchangeRateCollection::class,
            new ExchangeRateCollection()
        );
    }

    /**
     * @test
     */
    public function canContainMultipleItems()
    {
        $collection = new ExchangeRateCollection();
        $collection[] = new ExchangeRate("USD", "3.9876");
        $collection[] = new ExchangeRate("EUR", "4.1234");

        $this->assertEquals(
            2,
            $collection->count()
        );
    }

    /**
     * @test
     */
    public function canBeIteratedOver()
    {
        $iterations = 0;

        $collection = new ExchangeRateCollection();
        $collection[] = new ExchangeRate("USD", "3.9876");
        $collection[] = new ExchangeRate("EUR", "4.1234");
        $collection[] = new ExchangeRate("GBP", "4.7");

        /** @noinspection PhpUnusedLocalVariableInspection */
        foreach ($collection as $item) {
            ++$iterations;
        }

        $this->assertEquals(
            3,
            $iterations
        );
    }

    /**
     * @test
     */
    public function canReturnElementByKey()
    {
        $collection = new ExchangeRateCollection();
        $collection[] = new ExchangeRate("USD", "3.9876");
        $collection[] = new ExchangeRate("EUR", "4.1234");
        $collection[] = new ExchangeRate("GBP", "4.7");

        $this->assertEquals(
            "4.7",
            $collection[2]->getRate()
        );
    }

    /**
     * @test
     */
    public function cannotInsertNotSupportedElement()
    {
        $collection = new ExchangeRateCollection();
        $collection[] = null;
        $collection[] = "foo";
        $collection[] = 7;
        $collection[] = new ExchangeRate("GBP", "4.7");
        $collection[] = true;
        $collection[] = 100.01;
        $collection[] = new stdClass();

        $this->assertEquals(
            1,
            count($collection)
        );
    }
}
