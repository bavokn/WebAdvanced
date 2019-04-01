<?php

namespace Laudis\Calculators\Contracts;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface ResponseWriterInterface
 * Defines the rules to be able to write to the body of a response.
 *
 * @package Laudis\Calculators\Contracts
 */
interface ResponseWriterInterface
{
    /**
     * Writes the given data to the given response and modifies the statuscode if it is provided.
     *
     * @param ResponseInterface $response
     * @param mixed $data
     * @param int|null $statusCode
     * @return ResponseInterface
     */
    public function write(ResponseInterface $response, $data, ?int $statusCode = null): ResponseInterface;
}
