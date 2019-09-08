<?php
declare(strict_types=1);

namespace NBPFetch\Module;

use InvalidArgumentException;
use NBPFetch\Fetcher\Fetcher;
use NBPFetch\Parser\ParserInterface;
use NBPFetch\PathBuilder\PathBuilder;
use NBPFetch\PathBuilder\PathElement;

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
     * @param PathElement ...$pathElements
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function get(bool $inconstantResponse, PathElement ...$pathElements)
    {
        if (!empty($pathElements)) {
            foreach ($pathElements as $pathElement) {
                $this->pathBuilder->addElement($pathElement);
            }
        }

        $path = $this->pathBuilder->build();
        $responseArray = $this->fetcher->fetch($path, $inconstantResponse);
        return $this->parser->parse($responseArray);
    }
}
