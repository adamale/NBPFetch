<?php
declare(strict_types=1);

namespace NBPFetch\Module\CurrencyRate\TableResolver;

use InvalidArgumentException;
use NBPFetch\CurrencyTable\AbstractCurrencyTable;

/**
 * Class TableResolver
 * @package NBPFetch\Module\CurrencyRate\TableResolver
 */
class TableResolver implements TableResolverInterface
{
    /**
     * @var AbstractCurrencyTable[]
     */
    private $currencyTables;

    /**
     * TableResolver constructor.
     * @param AbstractCurrencyTable ...$currencyTables
     */
    public function __construct(AbstractCurrencyTable ...$currencyTables)
    {
        $this->currencyTables = $currencyTables;
    }

    /**
     * @param string $currency
     * @return string
     * @throws InvalidArgumentException
     */
    public function resolve(string $currency): string
    {
        $currency = mb_strtoupper($currency);

        foreach ($this->currencyTables as $currencyTable) {
            if (in_array($currency, $currencyTable->getCurrencies())) {
                return (string) $currencyTable;
            }
        }

        throw new InvalidArgumentException(
            "Given currency is not defined in the currency tables"
        );
    }
}
