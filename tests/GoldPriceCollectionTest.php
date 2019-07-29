<?php
declare(strict_types=1);

use NBPFetch\Structure\GoldPrice\GoldPrice;
use NBPFetch\Structure\GoldPrice\GoldPriceCollection;
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
        $collection->add(new GoldPrice("2019-07-28", "9.8765"));
        $collection->add(new GoldPrice("2019-07-29", "1.23"));
        $collection->add(new GoldPrice("2019-07-30", "42"));

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
        $collection->add(new GoldPrice("2019-07-28", "9.8765"));
        $collection->add(new GoldPrice("2019-07-29", "1.23"));
        $collection->add(new GoldPrice("2019-07-30", "42"));

        /** @noinspection PhpUnusedLocalVariableInspection */
        foreach ($collection as $item) {
            ++$iterations;
        }

        $this->assertEquals(
            3,
            $iterations
        );
    }
}
