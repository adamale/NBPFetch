<?php
declare(strict_types=1);

namespace NBPFetch;

use NBPFetch\CurrencyRate\ApiCaller as CurrencyRateApiCaller;
use NBPFetch\CurrencyRate\Fetcher as CurrencyRateFetcher;
use NBPFetch\CurrencyRate\TableResolver;
use NBPFetch\CurrencyRate\Validator as CurrencyRateValidator;
use NBPFetch\ExchangeRateTable\ApiCaller as ExchangeRateTableApiCaller;
use NBPFetch\ExchangeRateTable\Fetcher as ExchangeRateTableFetcher;
use NBPFetch\ExchangeRateTable\Validator as ExchangeRateTableValidator;
use NBPFetch\GoldPrice\ApiCaller as GoldPriceApiCaller;
use NBPFetch\GoldPrice\Fetcher as GoldPriceFetcher;
use NBPFetch\GoldPrice\Validator as GoldPriceValidator;
use NBPFetch\NBPApi\NBPApi;
use NBPFetch\Validation\CountValidator;
use NBPFetch\Validation\CurrencyValidator;
use NBPFetch\Validation\DateValidator;
use NBPFetch\Validation\TableValidator;

/**
 * Class NBPFetch
 * @package NBPFetch
 */
class NBPFetch
{
    /**
     * Returns gold price fetcher that defines various fetching methods.
     * @return GoldPriceFetcher
     */
    public function goldPrice(): GoldPriceFetcher
    {
        $NBPApi = new NBPApi();
        $apiCaller = new GoldPriceApiCaller($NBPApi);
        $validator = new GoldPriceValidator(
            new CountValidator(),
            new DateValidator()
        );

        return new GoldPriceFetcher($apiCaller, $validator);
    }

    /**
     * Returns exchange rate table fetcher that defines various fetching methods.
     * @return ExchangeRateTableFetcher
     */
    public function exchangeRateTable(): ExchangeRateTableFetcher
    {
        $NBPApi = new NBPApi();
        $apiCaller = new ExchangeRateTableApiCaller($NBPApi);
        $validator = new ExchangeRateTableValidator(
            new CountValidator(),
            new DateValidator(),
            new TableValidator()
        );

        return new ExchangeRateTableFetcher($apiCaller, $validator);
    }

    /**
     * Returns currency rate fetcher that defines various fetching methods.
     * @return CurrencyRateFetcher
     */
    public function currencyRate(): CurrencyRateFetcher
    {
        $NBPApi = new NBPApi();
        $apiCaller = new CurrencyRateApiCaller($NBPApi);
        $validator = new CurrencyRateValidator(
            new CountValidator(),
            new CurrencyValidator(),
            new DateValidator(),
            new TableValidator()
        );
        $tableResolver = new TableResolver();

        return new CurrencyRateFetcher($apiCaller, $validator, $tableResolver);
    }
}
