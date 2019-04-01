<?php

namespace Laudis\Calculators\Contracts;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Interface FinalExceptionHandler
 * Defines the class to be able to handle any exception.
 *
 * @package Laudis\Calculators\Contracts
 */
interface FinalExceptionHandler extends ExceptionHandlerInterface
{
    /**
     * Handles the exception by returning the appropriate response.
     *
     * @param ResponseInterface $response
     * @param Throwable $exception
     * @return ResponseInterface
     */
    public function handleException(ResponseInterface $response, Throwable $exception): ResponseInterface;
}
