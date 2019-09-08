<?php
declare(strict_types=1);

namespace NBPFetch\Module;

use InvalidArgumentException;
use NBPFetch\Fetcher\Fetcher;
use NBPFetch\Parser\ParserInterface;
use NBPFetch\PathBuilder\PathBuilder;
use NBPFetch\PathBuilder\PathSegment;

/**
 * Class AbstractModule
 * @package NBPFetch\Module
 */
abstract class AbstractModule
{
    /**
     * @var PathBuilder
     */
    protected $pathBuilder;

    /**
     * @var Fetcher
     */
    protected $fetcher;

    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * Returns parsed data from NBP API.
     * @param bool $inconstantResponse
     * @param PathSegment ...$pathSegments
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function get(bool $inconstantResponse, PathSegment ...$pathSegments)
    {
        $this->pathBuilder->addSegments(...$pathSegments);
        $responseArray = $this->fetcher->fetch($this->pathBuilder->build(), $inconstantResponse);

        return $this->parser->parse($responseArray);
    }
}
