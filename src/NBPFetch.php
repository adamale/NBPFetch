<?php
declare(strict_types=1);

namespace NBPFetch;

use NBPFetch\NBPApi\ExchangeRateTable\ApiCaller as ExchangeRateApiCaller;
use NBPFetch\NBPApi\ExchangeRateTable\Fetcher as ExchangeRateFetcher;
use NBPFetch\NBPApi\GoldPrice\ApiCaller as GoldPriceApiCaller;
use NBPFetch\NBPApi\GoldPrice\Fetcher as GoldPriceFetcher;
use NBPFetch\NBPApi\NBPApi;
use NBPFetch\NBPApi\Validator\CountValidator;
use NBPFetch\NBPApi\Validator\DateValidator;
use NBPFetch\NBPApi\Validator\TableValidator;

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

        return new GoldPriceFetcher(
            $apiCaller,
            new DateValidator(),
            new CountValidator()
        );
    }

    /**
     * Returns exchange rate table fetcher that defines various fetching methods.
     * @return ExchangeRateFetcher
     */
    public function exchangeRateTable(): ExchangeRateFetcher
    {
        $NBPApi = new NBPApi();
        $apiCaller = new ExchangeRateApiCaller($NBPApi);

        return new ExchangeRateFetcher(
            $apiCaller,
            new DateValidator(),
            new CountValidator(),
            new TableValidator()
        );
    }
}