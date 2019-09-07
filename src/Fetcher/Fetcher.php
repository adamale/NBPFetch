<?php
declare(strict_types=1);

namespace NBPFetch\Fetcher;

use DateTimeImmutable;
use DateTimeZone;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheException;
use UnexpectedValueException;

/**
 * Class Fetcher
 * @package NBPFetch\Fetcher
 */
class Fetcher implements FetcherInterface
{
    /**
     * @var string Base NBP API URL.
     */
    private const BASE_URL = "http://api.nbp.pl/api/";

    /**
     * @var CacheItemPoolInterface|null PSR-6 cache implementation.
     */
    private $cache;

    /**
     * Fetcher constructor.
     * @param CacheItemPoolInterface|null $cache
     */
    public function __construct(?CacheItemPoolInterface $cache = null)
    {
        $this->cache = $cache;
    }

    /**
     * Fetches a response and parses it for further processing.
     * @param string $path
     * @param bool $inconstantResponse Decides whether the response changes with time.
     * @return array
     */
    public function fetch(string $path, bool $inconstantResponse = true): array
    {
        // try to get the response from cache
        $response = (string) $this->fetchFromCache($path);

        // get the response from API if valid response could not have been got from cache
        // and try to store it in the cache
        if (mb_strlen($response) === 0) {
            $response = $this->fetchFromAPI($path);
            $this->storeResponseInCache($path, $response, $inconstantResponse);
        }

        // try to make an array from the response
        $parsedResponse = $this->parseResponse($response);

        // throw an exception if array was not created
        // (the fetched response was not a JSON, but an error string probably)
        if (!is_array($parsedResponse)) {
            throw new UnexpectedValueException("Error while fetching data from NBP API");
        }

        return $parsedResponse;
    }

    /**
     * Fetches the response from cache.
     * @param string $path
     * @return string|null
     */
    private function fetchFromCache(string $path): ?string
    {
        // check if there's a cache to get the response from
        if (!($this->cache instanceof CacheItemPoolInterface)) {
            return null;
        }

        try {
            // replace potentially disallowed characters with underscore
            $key = str_replace("/", "_", $path);

            // get the request path from cache
            $cachedResponse = $this->cache->getItem($key);

            // fetch the response from cache
            if ($cachedResponse->isHit()) {
                $response = $cachedResponse->get();
            }
        } catch (CacheException $e) {
        }

        return $response ?? "";
    }

    /**
     * Fetches the response from NBP API.
     * @param string $path
     * @return string
     */
    private function fetchFromAPI(string $path): string
    {
        // create context for the request to get proper response
        $context = stream_context_create([
            "http" => [
                "headers" => "Accept: application/json",
                "ignore_errors" => true
            ]
        ]);

        // fetch response from NBP API
        $response = (string) file_get_contents(
            self::BASE_URL . $path,
            false,
            $context
        );

        return $response;
    }

    /**
     * Stores a response in cache.
     * @param string $path
     * @param string $response
     * @param bool $inconstantResponse
     * @return bool|null
     */
    private function storeResponseInCache(string $path, string $response, bool $inconstantResponse): ?bool
    {
        // check if there's a cache to get the response from
        if (!($this->cache instanceof CacheItemPoolInterface)) {
            return null;
        }

        try {
            // replace potentially disallowed characters with underscore
            $key = str_replace("/", "_", $path);

            // get the request path from cache
            $cachedResponse = $this->cache->getItem($key);

            // set expire time to midnight if request doesn't return constant response
            // (i.e. the current data must not be stored longer than until midnight,
            // because the data changes on daily basis)
            if ($inconstantResponse) {
                $expireDate = new DateTimeImmutable(
                    "tomorrow",
                    new DateTimeZone("Europe/Warsaw")
                );
                $cachedResponse->expiresAt($expireDate);
            }

            // store the response in cache
            $cachedResponse->set($response);

            // save the cache state
            return $this->cache->save($cachedResponse);
        } catch (Exception|CacheException $e) {
            return false;
        }
    }

    /**
     * Tries to turn fetched response into an array.
     * @param string $response
     * @return array|null
     */
    private function parseResponse(string $response): ?array
    {
        return json_decode($response, true);
    }
}
