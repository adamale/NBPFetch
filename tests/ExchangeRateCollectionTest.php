<?php
declare(strict_types=1);

use NBPFetch\Structure\ExchangeRate\ExchangeRate;
use NBPFetch\Structure\ExchangeRate\ExchangeRateCollection;
use PHPUnit\Framework\TestCase;

/**
 * Class ExchangeRateCollectionTest
 * @covers \NBPFetch\Structure\ExchangeRate\ExchangeRateCollection
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
        $collection->add(new ExchangeRate("USD", "3.9876"));
        $collection->add(new ExchangeRate("EUR", "4.1234"));

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
        $collection->add(new ExchangeRate("USD", "3.9876"));
        $collection->add(new ExchangeRate("EUR", "4.1234"));
        $collection->add(new ExchangeRate("GBP", "4.7"));

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
