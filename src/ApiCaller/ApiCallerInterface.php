<?php
declare(strict_types=1);

namespace NBPFetch\ApiCaller;

use NBPFetch\NBPApi\NBPApiInterface;

/**
 * Class ApiCallerInterface
 * @package NBPFetch\ApiCaller
 */
interface ApiCallerInterface
{
    /**
     * @param NBPApiInterface $NBPApi
     * @return void
     */
    public function setNBPApi(NBPApiInterface $NBPApi): void;
}
