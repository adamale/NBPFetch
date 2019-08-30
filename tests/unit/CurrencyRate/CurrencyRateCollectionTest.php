<?php
declare(strict_types=1);

namespace NBPFetch\Tests\Unit\CurrencyRate;

use NBPFetch\CurrencyRate\Structure\CurrencyRate;
use NBPFetch\CurrencyRate\Structure\CurrencyRateCollection;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Class CurrencyRateCollectionTest
 * @package NBPFetch\Tests\Unit\CurrencyRate
 */
class CurrencyRateCollectionTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreated()
    {
        $this->assertInstanceOf(
            CurrencyRateCollection::class,
            new CurrencyRateCollection()
        );
    }

    /**
     * @test
     */
    public function canContainMultipleItems()
    {
        $collection = new CurrencyRateCollection();
        $collection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $collection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

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

        $collection = new CurrencyRateCollection();
        $collection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $collection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $collection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

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
        $collection = new CurrencyRateCollection();
        $collection[] = new CurrencyRate("161/A/NBP/2019", "2019-08-21", "4.1");
        $collection[] = new CurrencyRate("162/A/NBP/2019", "2019-08-22", "4");
        $collection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");

        $this->assertEquals(
            "3.9876",
            $collection[2]->getRate()
        );
    }

    /**
     * @test
     */
    public function cannotInsertNotSupportedElement()
    {
        $collection = new CurrencyRateCollection();
        $collection[] = null;
        $collection[] = "foo";
        $collection[] = 7;
        $collection[] = new CurrencyRate("163/A/NBP/2019", "2019-08-23", "3.9876");
        $collection[] = true;
        $collection[] = 100.01;
        $collection[] = new stdClass();

        $this->assertEquals(
            1,
            count($collection)
        );
    }
}
