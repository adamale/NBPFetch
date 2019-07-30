<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi;

use NBPFetch\NBPApi\Exception\InvalidResponseException;

/**
 * Interface NBPApiInterface
 * @package NBPFetch\NBPApi
 */
interface NBPApiInterface
{
    /**
     * @param string $url
     * @return array
     * @throws InvalidResponseException
     */
    public function fetch(string $url): array;
}