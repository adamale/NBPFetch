<?php
declare(strict_types=1);

namespace NBPFetch;

use NBPFetch\ApiCaller\ApiCallerSingleOrCollectionInterface;
use NBPFetch\GoldPrice\ApiCaller as GoldPriceApiCaller;
use NBPFetch\GoldPrice\Fetcher as GoldPriceFetcher;
use NBPFetch\GoldPrice\Validator as GoldPriceValidator;
use NBPFetch\GoldPrice\ValidatorInterface as GoldPriceValidatorInterface;
use NBPFetch\NBPApi\NBPApi;
use NBPFetch\NBPApi\NBPApiInterface;
use NBPFetch\Validation\CountValidator;
use NBPFetch\Validation\DateValidator;

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
}
