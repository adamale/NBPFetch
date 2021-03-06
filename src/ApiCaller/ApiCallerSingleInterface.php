<?php
declare(strict_types=1);

namespace NBPFetch\ApiCaller;

/**
 * Interface ApiCallerSingleInterface
 * @package NBPFetch\ApiCaller
 */
interface ApiCallerSingleInterface extends ApiCallerInterface
{
    /**
     * Returns full API response array.
     * @param string $path
     * @return mixed
     */
    public function get(string $path);
}
