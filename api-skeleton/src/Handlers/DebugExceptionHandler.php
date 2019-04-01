<?php

namespace Laudis\Calculators\Handlers;

use Laudis\Calculators\Contracts\FinalExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class DebugExceptionHandler.
 * Handles all exceptions in debug mode.
 *
 * @package Laudis\Calculators\Handlers
 */
final class DebugExceptionHandler extends BaseHandler implements FinalExceptionHandler
{
    /**
     * Handles the exception by returning the appropriate response if the exception applies to the handler.
     * @param ResponseInterface $response
     * @param Throwable $exception
     * @return ResponseInterface|null
     */
    public function handleException(ResponseInterface $response, Throwable $exception): ResponseInterface
    {
        return $this->writeJson($response, [
            'message' => $exception->getMessage(),
            'trace' => $exception->getTrace(),
        ], 500);
    }
}
