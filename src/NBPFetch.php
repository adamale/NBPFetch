<?php
declare(strict_types=1);

namespace NBPFetch;

use NBPFetch\ExchangeRateTable\ApiCaller as ExchangeRateApiCaller;
use NBPFetch\ExchangeRateTable\Fetcher as ExchangeRateFetcher;
use NBPFetch\ExchangeRateTable\Validator as ExchangeRateValidator;
use NBPFetch\GoldPrice\ApiCaller as GoldPriceApiCaller;
use NBPFetch\GoldPrice\Fetcher as GoldPriceFetcher;
use NBPFetch\GoldPrice\Validator as GoldPriceValidator;
use NBPFetch\NBPApi\NBPApi;
use NBPFetch\Validation\CountValidator;
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
     * @return ExchangeRateFetcher
     */
    public function exchangeRateTable(): ExchangeRateFetcher
    {
        $NBPApi = new NBPApi();
        $apiCaller = new ExchangeRateApiCaller($NBPApi);
        $validator = new ExchangeRateValidator(
            new CountValidator(),
            new DateValidator(),
            new TableValidator()
        );

        return new ExchangeRateFetcher($apiCaller, $validator);
    }
}
