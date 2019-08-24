<?php
declare(strict_types=1);

namespace NBPFetch\Validation;

use DateTimeImmutable;
use DateTimeZone;
use NBPFetch\Exception\InvalidDateException;

/**
 * Class DateValidator
 * @package NBPFetch\NBPApi\Validation
 */
class DateValidator implements DateValidatorInterface
{
    /**
     * @var string TIMEZONE Poland's timezone.
     */
    private const TIMEZONE = "Europe/Warsaw";

    /**
     * @var string MINIMAL_SUPPORTED_DATE Minimal supported date by NBP API.
     */
    private const MINIMAL_SUPPORTED_DATE = "2013-01-02";

    /**
     * @var string DATE_FORMAT Supported date format.
     */
    private const DATE_FORMAT = "Y-m-d";

    /**
     * @var DateTimeZone
     */
    private $timezone;

    /**
     * DateValidator constructor.
     */
    public function __construct()
    {
        $this->timezone = new DateTimeZone(self::TIMEZONE);
    }

    /**
     * Validates provided date.
     * @param string $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validate(string $date): bool
    {
        if (!$this->validateFormat($date)) {
            throw new InvalidDateException(
                sprintf("Date must be in %s format", self::DATE_FORMAT)
            );
        }

        $providedDate = DateTimeImmutable::createFromFormat(
            self::DATE_FORMAT,
            $date,
            $this->timezone
        );
        if ($providedDate === false) {
            throw new InvalidDateException(
                sprintf("Date could not be created")
            );
        }

        if (!$this->validateDateIsNotFromFuture($providedDate)) {
            throw new InvalidDateException(
                sprintf("Date must not be in the future")
            );
        } elseif (!$this->validateDateIsNotTooOld($providedDate)) {
            throw new InvalidDateException(
                sprintf("Date must not be before %s", self::MINIMAL_SUPPORTED_DATE)
            );
        }

        return true;
    }

    /**
     * Validates that provided date is properly formatted.
     * @param string $date
     * @return bool
     */
    protected function validateFormat(string $date): bool
    {
        $dti = DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $date);
        return $dti && $dti->format(self::DATE_FORMAT) === $date;
    }

    /**
     * Validates that provided date is not from future.
     * @param DateTimeImmutable $date
     * @return bool
     */
    protected function validateDateIsNotFromFuture(DateTimeImmutable $date): bool
    {
        $todayDate = DateTimeImmutable::createFromFormat(
            self::DATE_FORMAT,
            date("Y-m-d"),
            $this->timezone
        );

        return $date <= $todayDate;
    }

    /**
     * Validates that provided date is not too old.
     * @param DateTimeImmutable $date
     * @return bool
     */
    protected function validateDateIsNotTooOld(DateTimeImmutable $date): bool
    {
        $minimalSupportedDate = DateTimeImmutable::createFromFormat(
            self::DATE_FORMAT,
            self::MINIMAL_SUPPORTED_DATE,
            $this->timezone
        );

        return $date >= $minimalSupportedDate;
    }
}