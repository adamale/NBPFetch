<?php
declare(strict_types=1);

namespace NBPFetch;

use NBPFetch\NBPApi\GoldPrice\ApiCaller;
use NBPFetch\NBPApi\GoldPrice\Fetcher;
use NBPFetch\NBPApi\NBPApi;

/**
 * Class NBPFetch
 * @package NBPFetch
 */
class NBPFetch
{
    /**
     * Returns gold price fetcher that defines different fetching methods.
     * @return Fetcher
     */
    public function goldPrice(): Fetcher
    {
        $NBPApi = new NBPApi();
        $ApiCaller = new ApiCaller($NBPApi);

        return new Fetcher($ApiCaller);
    }
}