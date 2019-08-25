<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi;

use UnexpectedValueException;

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
     * Gets a response from NBP API and parses it for further processing.
     * @param string $path
     * @return array
     * @throws UnexpectedValueException
     */
    public function fetch(string $path): array
    {
        $context = stream_context_create([
            "http" => [
                "headers" => "Accept: application/json",
                "ignore_errors" => true
            ]
        ]);

        // get the API output
        $response = (string) file_get_contents(self::BASE_URL . $path, false, $context);

        // try to make an array from the response
        $parsedResponse = $this->parseResponse($response);

        // throw an exception if array was not created
        // (the API output was not a JSON, but an error string probably)
        if (!is_array($parsedResponse)) {
            throw new UnexpectedValueException("Error while fetching data from NBP API");
        }

        return $parsedResponse;
    }

    /**
     * Tries to turn fetched response into an array.
     * @param string $response
     * @return array|null
     */
    protected function parseResponse(string $response): ?array
    {
        return json_decode($response, true);
    }
}
