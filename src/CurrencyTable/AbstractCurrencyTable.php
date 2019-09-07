<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyTable;

/**
 * Class AbstractCurrencyTable
 * @package NBPFetch\CurrencyTable
 */
abstract class AbstractCurrencyTable
{
    /**
     * @var String
     */
    private const TABLE_TYPE = "";

    /**
     * @return string[] ISO 4217 currency codes that are defined in the table.
     */
    abstract public function getCurrencies(): array;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return static::TABLE_TYPE;
    }
}
