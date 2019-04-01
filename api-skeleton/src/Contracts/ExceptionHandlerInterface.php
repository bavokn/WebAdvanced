<?php

namespace Laudis\Calculators\Contracts;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Interface ExceptionHandlerInterface
 * Defines the class to be able to handle an exception.
 *
 * @package Laudis\Calculators\Contracts
 */
interface ExceptionHandlerInterface
{
    /**
     * Handles the exception by returning the appropriate response if the exception applies to the handler.
     *
     * @param ResponseInterface $response
     * @param Throwable $exception
     * @return ResponseInterface|null
     */
    public function handleException(ResponseInterface $response, Throwable $exception): ?ResponseInterface;
}
