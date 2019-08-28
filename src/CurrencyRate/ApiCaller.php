<?php
declare(strict_types=1);

namespace NBPFetch\CurrencyRate;

use NBPFetch\ApiCaller\AbstractApiCaller;
use NBPFetch\ApiCaller\ApiCallerSingleInterface;
use UnexpectedValueException;

/**
 * Class ApiCaller
 * @package NBPFetch\CurrencyRate
 */
class ApiCaller extends AbstractApiCaller implements ApiCallerSingleInterface
{
    /**
     * @var string API_SUBSET API Subset that returns currency exchange rate data.
     */
    private const API_SUBSET = "exchangerates/rates/";

    /**
     * Returns a currency rate series from given URL.
     * @param string $path
     * @return CurrencyRateSeries
     * @throws UnexpectedValueException
     */
    public function get(string $path): CurrencyRateSeries
    {
        $fetchedCurrencyRateSeries = $this->getNBPApi()->fetch(self::API_SUBSET . $path);
        return $this->createCurrencyRateSeries($fetchedCurrencyRateSeries);
    }

    /**
     * Creates an CurrencyRateSeries object from fetched array.
     * @param array $fetchedCurrencyRateSeries
     * @return CurrencyRateSeries
     */
    private function createCurrencyRateSeries(array $fetchedCurrencyRateSeries): CurrencyRateSeries
    {
        $rateCollection = new CurrencyRateCollection();
        foreach ($fetchedCurrencyRateSeries["rates"] as $rate) {
            $rateCollection[] = new CurrencyRate(
                $rate["no"],
                $rate["effectiveDate"],
                (string) $rate["mid"]
            );
        }

        return new CurrencyRateSeries(
            $fetchedCurrencyRateSeries["table"],
            $fetchedCurrencyRateSeries["currency"],
            $fetchedCurrencyRateSeries["code"],
            $rateCollection
        );
    }
}
