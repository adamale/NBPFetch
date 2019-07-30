<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\ApiCaller;

/**
 * Interface ApiCallerInterface
 * @package NBPFetch\NBPApi\ApiCaller
 */
interface ApiCallerInterface
{
    /**
     * @param string $url
     * @return mixed
     */
    public function getSingle(string $url);

    /**
     * @param string $url
     * @return mixed
     */
    public function getCollection(string $url);

    /**
     * @return string
     */
    public function getDateFormat(): string;
}