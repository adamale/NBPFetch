<?php
declare(strict_types=1);

namespace NBPFetch\NBPApi\Fetcher;

use NBPFetch\NBPApi\ApiCaller\ApiCallerInterface;
use NBPFetch\NBPApi\Validator\CountValidatorInterface;
use NBPFetch\NBPApi\Validator\DateValidatorInterface;

/**
 * Class AbstractFetcher
 * @package NBPFetch\NBPApi\Fetcher
 */
class AbstractFetcher implements FetcherInterface
{
    /**
     * @var ApiCallerInterface
     */
    protected $apiCaller;

    /**
     * @var DateValidatorInterface
     */
    protected $dateValidator;

    /**
     * @var CountValidatorInterface
     */
    protected $countValidator;

    /**
     * @param ApiCallerInterface $apiCaller
     * @param DateValidatorInterface $dateValidator
     * @param CountValidatorInterface $countValidator
     */
    public function __construct(
        ApiCallerInterface $apiCaller,
        DateValidatorInterface $dateValidator,
        CountValidatorInterface $countValidator
    ) {
        $this->apiCaller = $apiCaller;
        $this->dateValidator = $dateValidator;
        $this->countValidator = $countValidator;
    }

    /**
     * @return ApiCallerInterface
     */
    public function getApiCaller()
    {
        return $this->apiCaller;
    }

    /**
     * @return DateValidatorInterface
     */
    public function getDateValidator(): DateValidatorInterface
    {
        return $this->dateValidator;
    }

    /**
     * @return CountValidatorInterface
     */
    public function getCountValidator(): CountValidatorInterface
    {
        return $this->countValidator;
    }
}