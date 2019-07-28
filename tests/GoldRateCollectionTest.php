<?php
declare(strict_types=1);

use NBPFetch\GoldRate;
use NBPFetch\GoldRateCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class GoldRateCollectionTest
 * @covers NBPFetch\GoldRateCollection
 */
class GoldRateCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreated()
    {
        $this->assertInstanceOf(
            "NBPFetch\GoldRateCollection",
            new GoldRateCollection()
        );
    }

    /**
     * @test
     */
    public function canContainMultipleItems()
    {
        $collection = new GoldRateCollection();
        $collection->add(new GoldRate("2019-07-28", "9.8765"));
        $collection->add(new GoldRate("2019-07-29", "1.23"));
        $collection->add(new GoldRate("2019-07-30", "42"));

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

        $collection = new GoldRateCollection();
        $collection->add(new GoldRate("2019-07-28", "9.8765"));
        $collection->add(new GoldRate("2019-07-29", "1.23"));
        $collection->add(new GoldRate("2019-07-30", "42"));

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
