<?php

namespace Laudis\Calculators\Strategies;

use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class WriteJsonToResponse
 * Implements the response writer by writing json to the response.
 *
 * @package Laudis\Calculators\Strategies
 */
final class WriteJsonToResponse implements ResponseWriterInterface
{
    public function write(ResponseInterface $response, $data, ?int $statusCode = null): ResponseInterface
    {
        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));
        if ($statusCode !== null) {
            return $response->withStatus($statusCode);
        }
        return $response;
    }
}
