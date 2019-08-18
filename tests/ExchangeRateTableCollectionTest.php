<?php
declare(strict_types=1);

use NBPFetch\Structure\ExchangeRate\ExchangeRateCollection;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTable;
use NBPFetch\Structure\ExchangeRate\ExchangeRateTableCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class ExchangeRateTableCollectionTest
 * @covers \NBPFetch\Structure\ExchangeRate\ExchangeRateTableCollection
 */
final class ExchangeRateTableCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreated()
    {
        $this->assertInstanceOf(
            ExchangeRateTableCollection::class,
            new ExchangeRateTableCollection()
        );
    }

    /**
     * @test
     */
    public function canContainMultipleItems()
    {
        $collection = new ExchangeRateTableCollection();
        $collection[] = new ExchangeRateTable(
            "A",
            "156/A/NBP/2019",
            "2019-08-13",
            new ExchangeRateCollection()
        );
        $collection[] =  new ExchangeRateTable(
            "A",
            "155/A/NBP/2019",
            "2019-08-12",
            new ExchangeRateCollection()
        );

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

        $collection = new ExchangeRateTableCollection();
        $collection[] = new ExchangeRateTable(
            "A",
            "156/A/NBP/2019",
            "2019-08-13",
            new ExchangeRateCollection()
        );
        $collection[] = new ExchangeRateTable(
            "A",
            "155/A/NBP/2019",
            "2019-08-12",
            new ExchangeRateCollection()
        );
        $collection[] = new ExchangeRateTable(
            "A",
            "154/A/NBP/2019",
            "2019-08-09",
            new ExchangeRateCollection()
        );

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
        $collection = new ExchangeRateTableCollection();
        $collection[] = new ExchangeRateTable(
            "A",
            "156/A/NBP/2019",
            "2019-08-13",
            new ExchangeRateCollection()
        );
        $collection[] = new ExchangeRateTable(
            "A",
            "155/A/NBP/2019",
            "2019-08-12",
            new ExchangeRateCollection()
        );
        $collection[] = new ExchangeRateTable(
            "A",
            "154/A/NBP/2019",
            "2019-08-09",
            new ExchangeRateCollection()
        );

        $this->assertEquals(
            "154/A/NBP/2019",
            $collection[2]->getNumber()
        );
    }

    /**
     * @test
     */
    public function cannotInsertNotSupportedElement()
    {
        $collection = new ExchangeRateTableCollection();
        $collection[] = null;
        $collection[] = "foo";
        $collection[] = 7;
        $collection[] = new ExchangeRateTable(
            "A",
            "154/A/NBP/2019",
            "2019-08-09",
            new ExchangeRateCollection()
        );
        $collection[] = true;
        $collection[] = 100.01;
        $collection[] = new StdClass();

        $this->assertEquals(
            1,
            count($collection)
        );
    }
}
