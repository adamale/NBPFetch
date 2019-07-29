<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi;

use InvalidArgumentException;

/**
 * Class NBPApi
 * @package NBPFetch\NBPApi
 */
class NBPApi
{
    /**
     * @var string
     */
    private const BASE_URL = "http://api.nbp.pl/api/";

    /**
     * @param string $url
     * @return array
     * @throws InvalidArgumentException
     */
    public function fetch(string $url): array
    {
        $context = stream_context_create([
            "http" => [
                "headers" => "Accept: application/json",
                "ignore_errors" => true
            ]
        ]);

        $response = file_get_contents(self::BASE_URL . $url, false, $context);

        $decoded = json_decode($response, true);

        if (is_array($decoded)) {
            return $decoded;
        } else {
            throw new InvalidArgumentException($response);
        }
    }
}