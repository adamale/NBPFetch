<?php
declare(strict_types=1);

namespace NBPFetch\Parser;

/**
 * Interface ParserInterface
 * @package NBPFetch\Parser
 */
interface ParserInterface
{
    /**
     * @param array $fetchedResponse
     * @return mixed
     */
    public function parse(array $fetchedResponse);
}
