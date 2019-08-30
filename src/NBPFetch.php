<?php
declare(strict_types=1);

namespace NBPFetch;

use NBPFetch\ApiCaller\ApiCallerSingleOrCollectionInterface;
use NBPFetch\ExchangeRateTable\ApiCaller as ExchangeRateTableApiCaller;
use NBPFetch\ExchangeRateTable\Fetcher as ExchangeRateTableFetcher;
use NBPFetch\ExchangeRateTable\Validator as ExchangeRateTableValidator;
use NBPFetch\ExchangeRateTable\ValidatorInterface as ExchangeRateTableValidatorInterface;
use NBPFetch\GoldPrice\ApiCaller as GoldPriceApiCaller;
use NBPFetch\GoldPrice\Fetcher as GoldPriceFetcher;
use NBPFetch\GoldPrice\Validator as GoldPriceValidator;
use NBPFetch\GoldPrice\ValidatorInterface as GoldPriceValidatorInterface;
use NBPFetch\NBPApi\NBPApi;
use NBPFetch\NBPApi\NBPApiInterface;
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
     * @var NBPApiInterface
     */
    private $NBPApi;

    /**
     * NBPFetch constructor.
     * @param NBPApiInterface|null $NBPApi
     */
    public function __construct(?NBPApiInterface $NBPApi = null)
    {
        $this->NBPApi = $NBPApi ?? new NBPApi();
    }

    /**
     * Returns gold price fetcher that defines various fetching methods.
     * @param ApiCallerSingleOrCollectionInterface|null $apiCaller
     * @param GoldPriceValidatorInterface|null $validator
     * @return GoldPriceFetcher
     */
    public function goldPrice(
        ?ApiCallerSingleOrCollectionInterface $apiCaller = null,
        ?GoldPriceValidatorInterface $validator = null
    ): GoldPriceFetcher {
        if ($apiCaller === null) {
            $apiCaller = new GoldPriceApiCaller();
        }
        $apiCaller->setNBPApi($this->NBPApi);

        if ($validator === null) {
            $validator = new GoldPriceValidator(new CountValidator(), new DateValidator());
        }

        return new GoldPriceFetcher($apiCaller, $validator);
    }

    /**
     * Returns exchange rate table fetcher that defines various fetching methods.
     * @param ApiCallerSingleOrCollectionInterface|null $apiCaller
     * @param ExchangeRateTableValidatorInterface|null $validator
     * @return ExchangeRateTableFetcher
     */
    public function exchangeRateTable(
        ?ApiCallerSingleOrCollectionInterface $apiCaller = null,
        ?ExchangeRateTableValidatorInterface $validator = null
    ): ExchangeRateTableFetcher {
        if ($apiCaller === null) {
            $apiCaller = new ExchangeRateTableApiCaller();
        }
        $apiCaller->setNBPApi($this->NBPApi);

        if ($validator === null) {
            $validator = new ExchangeRateTableValidator(
                new CountValidator(),
                new DateValidator(),
                new TableValidator()
            );
        }

        return new ExchangeRateTableFetcher($apiCaller, $validator);
    }
}
