<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\Validator;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use NBPFetch\NBPApi\Exception\InvalidDateException;

class DateValidator implements DateValidatorInterface
{
    /**
     * @var string TIMEZONE Poland's timezone.
     */
    private const TIMEZONE = "Europe/Warsaw";

    /**
     * @var string TIMEZONE Minimal supported date by NBP API.
     */
    private const MINIMAL_SUPPORTED_DATE = "2013-01-02";

    /**
     * @var string DATE_FORMAT Supported date format.
     */
    private const DATE_FORMAT = "Y-m-d";

    /**
     * Validates that provided date is properly formatted.
     * @param string|array $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validateDateFormat($date): bool
    {
        $dates = (array) $date;

        foreach ($dates as $date) {
            $dti = DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $date);
            if (!$dti || $dti->format(self::DATE_FORMAT) !== $date) {
                throw new InvalidDateException(
                    sprintf("Date must be in %s format", self::DATE_FORMAT)
                );
            }
        }

        return true;
    }

    /**
     * Validates that provided date is in proper range.
     * @param string|array $date
     * @return bool
     * @throws InvalidDateException
     */
    public function validateDate($date): bool
    {
        $dates = (array) $date;

        $timeZone = new DateTimeZone(self::TIMEZONE);
        $today = date("Y-m-d");

        $minimalSupportedDate = DateTimeImmutable::createFromFormat(
            self::DATE_FORMAT,
            self::MINIMAL_SUPPORTED_DATE,
            $timeZone
        );

        $todayDate = DateTimeImmutable::createFromFormat(
            self::DATE_FORMAT,
            $today,
            $timeZone
        );

        foreach ($dates as $date) {
            $providedDate = DateTimeImmutable::createFromFormat(
                self::DATE_FORMAT,
                $date,
                $timeZone
            );

            if ($providedDate > $todayDate) {
                throw new InvalidArgumentException(
                    sprintf("Date must not be in the future (after %s)", $today)
                );
            } elseif ($providedDate < $minimalSupportedDate) {
                throw new InvalidArgumentException(
                    sprintf("Date must not be before %s", self::MINIMAL_SUPPORTED_DATE)
                );
            }
        }

        return true;
    }
}