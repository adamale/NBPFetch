<?php
declare(strict_types=1);

namespace NBPFetch\Fetcher;

use NBPFetch\ApiCaller\ApiCallerInterface;
use NBPFetch\Validation\CountValidatorInterface;
use NBPFetch\Validation\DateValidatorInterface;
use NBPFetch\Validation\TableValidatorInterface;

/**
 * Class AbstractFetcher
 * @package NBPFetch\Fetcher
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
     * @var TableValidatorInterface
     */
    protected $tableValidator;

    /**
     * @param ApiCallerInterface $apiCaller
     * @param DateValidatorInterface $dateValidator
     * @param CountValidatorInterface $countValidator
     * @param TableValidatorInterface|null $tableValidator
     */
    public function __construct(
        ApiCallerInterface $apiCaller,
        DateValidatorInterface $dateValidator,
        CountValidatorInterface $countValidator,
        ?TableValidatorInterface $tableValidator = null
    )
    {
        $this->apiCaller = $apiCaller;
        $this->dateValidator = $dateValidator;
        $this->countValidator = $countValidator;
        $this->tableValidator = $tableValidator;
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

    /**
     * @return TableValidatorInterface
     */
    public function getTableValidator(): TableValidatorInterface
    {
        return $this->tableValidator;
    }
}