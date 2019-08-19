<?php
declare(strict_types=1);

use NBPFetch\GoldPrice\GoldPrice;
use NBPFetch\GoldPrice\GoldPriceCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class GoldPriceCollectionTest
 * @covers NBPFetch\GoldPriceCollection
 */
final class GoldPriceCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreated()
    {
        $this->assertInstanceOf(
            GoldPriceCollection::class,
            new GoldPriceCollection()
        );
    }

    /**
     * @test
     */
    public function canContainMultipleItems()
    {
        $collection = new GoldPriceCollection();
        $collection[] = new GoldPrice("2019-07-28", "9.8765");
        $collection[] = new GoldPrice("2019-07-29", "1.23");
        $collection[] = new GoldPrice("2019-07-30", "42");

        $this->assertEquals(
            3,
            $collection->count()
        );
    }

    /**
     * @test
     */
    public function canBeIteratedOver()
    {
        $iterations = 0;

        $collection = new GoldPriceCollection();
        $collection[] = new GoldPrice("2019-07-28", "9.8765");
        $collection[] = new GoldPrice("2019-07-29", "1.23");
        $collection[] = new GoldPrice("2019-07-30", "42");

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
        $collection = new GoldPriceCollection();
        $collection[] = new GoldPrice("2019-07-28", "9.8765");
        $collection[] = new GoldPrice("2019-07-29", "1.23");
        $collection[] = new GoldPrice("2019-07-30", "42");

        $this->assertEquals(
            "2019-07-30",
            $collection[2]->getDate()
        );
    }

    /**
     * @test
     */
    public function cannotInsertNotSupportedElement()
    {
        $collection = new GoldPriceCollection();
        $collection[] = null;
        $collection[] = "foo";
        $collection[] = 7;
        $collection[] = new GoldPrice("2019-07-30", "42");
        $collection[] = true;
        $collection[] = 100.01;
        $collection[] = new StdClass();

        $this->assertEquals(
            1,
            count($collection)
        );
    }
}
