<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\GoldPrice;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use NBPFetch\NBPApi\Exception\InvalidDateException;
use NBPFetch\NBPApi\Exception\InvalidResponseException;
use NBPFetch\NBPApi\Fetcher\AbstractFetcher;
use NBPFetch\Structure\GoldPrice\GoldPrice;
use NBPFetch\Structure\GoldPrice\GoldPriceCollection;

/**
 * Class Fetcher
 * @package NBPFetch\NBPApi\GoldPrice
 */
class Fetcher extends AbstractFetcher
{
    /**
     * @var string TIMEZONE Poland's timezone.
     */
    private const TIMEZONE = "Europe/Warsaw";

    /**
     * @var string TIMEZONE Poland's timezone.
     */
    private const MINIMAL_ACCEPTED_DATE = "2013-01-02";

    /**
     * Returns current gold price.
     * @return GoldPrice|null
     * @throws InvalidResponseException
     */
    public function current(): ?GoldPrice
    {
        return $this->apiCaller->getSingle("");
    }

    /**
     * Returns a set of n last gold prices.
     * @param int $count Must be an positive integer.
     * @return GoldPriceCollection|null
     * @throws InvalidArgumentException|InvalidResponseException
     */
    public function last(int $count): ?GoldPriceCollection
    {
        $minimalCount = 1;
        if ($count < $minimalCount) {
            throw new InvalidArgumentException(
                sprintf("Count must not be lower than %s", $minimalCount)
            );
        }

        return $this->apiCaller->getCollection("last/" . ((string) $count) . "/");
    }

    /**
     * Returns today gold price.
     * @return GoldPrice|null
     * @throws InvalidResponseException
     */
    public function today(): ?GoldPrice
    {
        return $this->apiCaller->getSingle("today/");
    }

    /**
     * Returns a given date gold price.
     * @param string $date Date in Y-m-d format.
     * @return GoldPrice|null
     * @throws InvalidArgumentException|InvalidResponseException
     */
    public function byDate(string $date): ?GoldPrice
    {
        try {
            $this->validateDate($date);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->apiCaller->getSingle($date . "/");
    }

    /**
     * Returns a set of gold prices between given dates.
     * @param string $from  Date in Y-m-d format.
     * @param string $to    Date in Y-m-d format.
     * @return GoldPriceCollection|null
     * @throws InvalidArgumentException|InvalidResponseException
     */
    public function byDateRange(string $from, string $to): ?GoldPriceCollection
    {
        try {
            $this->validateDate($from);
            $this->validateDate($to);
        } catch (InvalidDateException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

        return $this->apiCaller->getCollection($from . "/" . $to);
    }

    /**
     * @param string $date
     * @return bool
     * @throws InvalidDateException
     */
    protected function validateDate(string $date): bool
    {
        $dateFormat = $this->getApiCaller()->getDateFormat();

        $this->validateDateFormat($date, $dateFormat);
        $this->validateDateIsInCorrectRange($date, $dateFormat);

        return true;
    }

    /**
     * @param $date
     * @param $dateFormat
     * @return void
     * @throws InvalidDateException
     */
    private function validateDateFormat($date, $dateFormat): void
    {
        $dti = DateTimeImmutable::createFromFormat($dateFormat, $date);
        if (!$dti || $dti->format($dateFormat) !== $date) {
            throw new InvalidDateException(
                sprintf("Date must be in %s format", $dateFormat)
            );
        }
    }

    /**
     * @param $date
     * @param $dateFormat
     * @return void
     * @throws InvalidDateException
     */
    private function validateDateIsInCorrectRange($date, $dateFormat): void
    {
        $timeZone = new DateTimeZone(self::TIMEZONE);
        $today = date("Y-m-d");

        // date passed to method
        $providedDate = DateTimeImmutable::createFromFormat(
            $dateFormat,
            $date,
            $timeZone
        );

        // today's date
        $currentDate = DateTimeImmutable::createFromFormat(
            $dateFormat,
            $today,
            $timeZone
        );

        // minimal date accepted by NBP API
        $minimalAcceptedDate = DateTimeImmutable::createFromFormat(
            $dateFormat,
            self::MINIMAL_ACCEPTED_DATE,
            $timeZone
        );

        if ($providedDate > $currentDate) {
            throw new InvalidArgumentException(
                sprintf("Date must not be in the future (after %s)", $today)
            );
        } elseif ($providedDate < $minimalAcceptedDate) {
            throw new InvalidArgumentException(
                sprintf("Date must not be before %s", self::MINIMAL_ACCEPTED_DATE)
            );
        }
    }
}