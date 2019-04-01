<?php

namespace Laudis\Calculators\Handlers;

use Laudis\Calculators\Contracts\ExceptionHandlerInterface;
use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Strategies\WriteJsonToResponse;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class BaseHandler
 * Implements the basic behauviour of an exception handler.
 *
 * @package Laudis\Calculators\Handlers
 */
abstract class BaseHandler implements ExceptionHandlerInterface
{
    /** @var WriteJsonToResponse */
    private $jsonToResponse;

    /**
     * BaseHandler constructor.
     * @param ResponseWriterInterface $jsonToResponse
     */
    public function __construct(ResponseWriterInterface $jsonToResponse)
    {
        $this->jsonToResponse = $jsonToResponse;
    }

    /**
     * Writes the data to the given response and overrides the statuscode if provided.
     * @param Response $response
     * @param array $data
     * @param int|null $statusCode
     * @return Response
     */
    final protected function writeJson(Response $response, array $data, int $statusCode = null): Response
    {
        return $this->jsonToResponse->write($response, $data, $statusCode);
    }
}
