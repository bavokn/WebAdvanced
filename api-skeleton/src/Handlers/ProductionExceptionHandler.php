<?php

namespace Laudis\Calculators\Handlers;

use Laudis\Calculators\Contracts\FinalExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class ProductionExceptionHandler
 * Handles all exceptions in production.
 *
 * @package Laudis\Calculators\Handlers
 */
final class ProductionExceptionHandler extends BaseHandler implements FinalExceptionHandler
{
    /**
     * @param ResponseInterface $response
     * @param Throwable $exception
     * @return ResponseInterface
     */
    public function handleException(ResponseInterface $response, Throwable $exception): ResponseInterface
    {
        return $this->writeJson($response, [
            'message' => 'Er is iets verkeerd gebeurd'
        ], 500);
    }
}
