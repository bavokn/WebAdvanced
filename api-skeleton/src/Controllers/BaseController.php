<?php

namespace Laudis\Calculators\Controllers;

use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Strategies\WriteJsonToResponse;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class BaseController
 * Common controller behaviour able to write to the response.
 *
 * @package Laudis\Calculators\Controllers
 */
abstract class BaseController
{
    /** @var ResponseWriterInterface */
    //create a responsewriter so view is not actually necessary ==> returns a json file TODO - what do you mean?
    private $responseWriter;

    /**
     * BaseController constructor.
     *
     * @param ResponseWriterInterface|null $responseWriter
     */
    public function __construct(ResponseWriterInterface $responseWriter = null)
    {
        $this->responseWriter = $responseWriter ?? new WriteJsonToResponse;
    }

    /**
     * Writes the given data to the given response and overrides the statuscode if provided.
     *
     * @param Response $response
     * @param mixed $data
     * @param int|null $statusCode
     * @return Response
     */
    final protected function writeToResponse(Response $response, $data, ?int $statusCode = null): Response
    {
        return $this->responseWriter->write($response, $data, $statusCode);
    }
}
