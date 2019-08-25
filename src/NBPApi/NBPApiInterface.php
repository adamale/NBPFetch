<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi;

use UnexpectedValueException;

/**
 * Interface NBPApiInterface
 * @package NBPFetch\NBPApi
 */
interface NBPApiInterface
{
    /**
     * @param string $url
     * @return array
     * @throws UnexpectedValueException
     */
    public function fetch(string $url): array;
}
