<?php
declare(strict_types=1);

namespace NBPFetch\GoldPrice;

use InvalidArgumentException;
use NBPFetch\ApiCaller\ApiCallerInterface;
use NBPFetch\Exception\InvalidCountException;
use NBPFetch\Exception\InvalidDateException;
use UnexpectedValueException;

/**
 * Class Fetcher
 * @package NBPFetch\GoldPrice
 */
class Fetcher
{
    /**
     * @var ApiCallerInterface
     */
    private $apiCaller;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ApiCallerInterface $apiCaller
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ApiCallerInterface $apiCaller,
        ValidatorInterface $validator
    ) {
        $this->apiCaller = $apiCaller;
        $this->validator = $validator;
    }

    /**
     * Returns current gold price.
     * @return GoldPrice|null
     * @throws UnexpectedValueException
     */
    public function current(): ?GoldPrice
    {
        return $this->apiCaller->getSingle("");
    }

    /**
     * Returns a set of n last gold prices.
     * @param int $count Must be an positive integer.
     * @return GoldPriceCollection|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function last(int $count): ?GoldPriceCollection
    {
        try {
            $this->validator->getCountValidator()->validate($count);
        } catch (InvalidCountException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("last/%s", $count);

        return $this->apiCaller->getCollection($path);
    }

    /**
     * Returns today gold price.
     * @return GoldPrice|null
     * @throws UnexpectedValueException
     */
    public function today(): ?GoldPrice
    {
        return $this->apiCaller->getSingle("today/");
    }

    /**
     * Returns a given date gold price.
     * @param string $date Date in Y-m-d format.
     * @return GoldPrice|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDate(string $date): ?GoldPrice
    {
        try {
            $this->validator->getDateValidator()->validate($date);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/", $date);

        return $this->apiCaller->getSingle($path);
    }

    /**
     * Returns a set of gold prices between given dates.
     * @param string $from  Date in Y-m-d format.
     * @param string $to    Date in Y-m-d format.
     * @return GoldPriceCollection|null
     * @throws InvalidArgumentException|UnexpectedValueException
     */
    public function byDateRange(string $from, string $to): ?GoldPriceCollection
    {
        try {
            $this->validator->getDateValidator()->validate($from);
            $this->validator->getDateValidator()->validate($to);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        $path = sprintf("%s/%s", $from, $to);

        return $this->apiCaller->getCollection($path);
    }
}