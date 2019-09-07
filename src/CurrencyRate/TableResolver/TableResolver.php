<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate\TableResolver;

use InvalidArgumentException;
use NBPFetch\CurrencyTable\CurrencyTableCollection;

/**
 * Class TableResolver
 * @package NBPFetch\CurrencyRate\TableResolver
 */
class TableResolver implements TableResolverInterface
{
    /**
     * @var CurrencyTableCollection
     */
    private $currencyTableCollection;

    /**
     * TableResolver constructor.
     * @param CurrencyTableCollection $currencyTableCollection
     */
    public function __construct(CurrencyTableCollection $currencyTableCollection)
    {
        $this->currencyTableCollection = $currencyTableCollection;
    }

    /**
     * @param string $currency
     * @return string
     * @throws InvalidArgumentException
     */
    public function resolve(string $currency): string
    {
        $currency = mb_strtoupper($currency);

        foreach ($this->currencyTableCollection as $currencyTable) {
            if (in_array($currency, $currencyTable->getCurrencies())) {
                return (string) $currencyTable;
            }
        }

        throw new InvalidArgumentException(
            "Given currency is not defined in the currency tables"
        );
    }
}
