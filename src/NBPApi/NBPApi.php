<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi;

use NBPFetch\NBPApi\Exception\InvalidResponseException;

/**
 * Class NBPApi
 * @package NBPFetch\NBPApi
 */
class NBPApi implements NBPApiInterface
{
    /**
     * @var string
     */
    private const BASE_URL = "http://api.nbp.pl/api/";

    /**
     * Gets a response from NBP API and parses it for further action.
     * @param string $url
     * @return array
     * @throws InvalidResponseException
     */
    public function fetch(string $url): array
    {
        $context = stream_context_create([
            "http" => [
                "headers" => "Accept: application/json",
                "ignore_errors" => true
            ]
        ]);

        // get the API output
        $response = file_get_contents(self::BASE_URL . $url, false, $context);

        // try to make an array from the response
        $parseResponse = $this->parseResponse($response);

        // throw an exception if array was not created
        // (the API output was not a JSON, but an error string probably)
        if (!is_array($parseResponse)) {
            throw new InvalidResponseException($response);
        }

        return $parseResponse;
    }

    /**
     * Tries to turn fetched response JSON into an array.
     * @param string $response
     * @return array|null
     */
    protected function parseResponse(string $response): ?array
    {
        return json_decode($response, true);
    }
}